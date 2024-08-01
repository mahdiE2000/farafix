<?php

    namespace App\Services\Notification\Batch;

use App\Models\SmsBatch;
use App\Services\Notification\Events\SmsSent;
use App\Services\Notification\Events\SmsSentAgain;
use App\Services\Notification\MessagePattern\Pattern;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use SoapClient;

class PeerToPeer
{
    protected Collection $collection;
    protected array $config;
    protected Pattern $messagePatternClass;
    protected string $messagePattern;
    protected string $operator;
    protected bool $isAdmin = false;
    protected bool $isSystematic = false;
    protected int $price = -80;

    public function __construct(string $message, Collection $collection, string $category, $uniqueCode, $operator = 'advertise')
    {
        if ($this->isValidCost() || $operator == 'service') {
            $this->operator = ($operator == 'advertise') ? 'rahyab_advertise' : 'rahyab_service';
            $this->collection = $collection;
            $this->messagePatternClass = new Pattern($message);
            $this->messagePattern = $this->messagePatternClass->getPattern();
            $this->config = array_merge($this->createExtra($category, $uniqueCode), config('notification.drivers.' . $this->operator));

            if (isset($this->config['operator'])) {
                if (str_contains($this->config['operator'], 'advertise')) {
                    $this->config['type'] = 'advertise';
                } else {
                    $this->config['type'] = 'service';
                }
            }

            try {
                $this->client = new SoapClient( $this->config[ 'url' ] );
            } catch ( \SoapFault $e ) {
                dd($e->getMessage());
            }
        }
    }

    private function isValidCost(): bool
    {
        if ( $this->price > -50000.00) {
            return true;
        } else {
            return false;
        }
    }

    public function isSystematic($isSystematic = 0): static
    {
        $this->isSystematic = $isSystematic;
        return $this;
    }

    public function isAdmin($isAdmin = 0): static
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }

    public function send($userData): void
    {
        if ($this->collection->count() <= config('notification.max_phone_size.do_send_sms_array_c')) {
            $this->setIsAdminAndIsSystematicInConfig();
            $payload = $this->payload($userData);
            $response = $this->client->doSendSMSArrayC($payload)->doSendSMSArrayCResult->DataSendOut;
            $this->serializeToDatabase($payload['uDataSendIn'], $response);
        }
    }

    public function sendAgain($userData, SmsBatch $smsBatch): void
    {
        if ($this->collection->count() <= config('notification.max_phone_size.do_send_sms_array_c')) {
            $payload = $this->payload($userData);
            $response = $this->client->doSendSMSArrayC($payload)->doSendSMSArrayCResult->DataSendOut;
            $this->updateToDatabase($payload['uDataSendIn'], $response, $smsBatch);
        }
    }

    protected function payload($userData): array
    {
        $data = [];
        foreach ($this->collection as $key => $item) {
            $data[$key] = $this->prepareData($item, $userData);
        }
        return array(
            'uUsername' => $this->config['username'],
            'uPassword' => $this->config['password'],
            'uDataSendIn' => $data
        );
    }

    protected function prepareData(Model $model, $userData): array
    {
        $fillable = is_null($userData) ? $model : $userData;

        return [
            'ClientID' => rand(1, 1000000000000000),
            'ShortCode' => $this->findFrom(),
            'Cellphone' => $model->getPhone(),
            'Message' => $this->messagePatternClass->fill($fillable),
            'Farsi' => true,
            'Flash' => false,
            'UDH' => '',
            'ServiceID' => ''
        ];
    }

    protected function findFrom()
    {
        $smsOperatorConfig = collect(config('notification.config_system'));

        if (is_null($smsOperatorConfig) or $smsOperatorConfig->isEmpty()) {
            return $this->config['from'];
        }

        $customConfig = $smsOperatorConfig->getConfig($this->operator);

        if (is_null($customConfig)) {
            return $this->config['from'];
        }

        return $customConfig['from'];
    }

    protected function serializeToDatabase($payload, $response): void
    {
        $this->collection->count() > 1 ?: $response = [$response];
        event(new SmsSent($this->collection, json_decode(json_encode($response), true), $payload, $this->config));
    }

    protected function updateToDatabase($payload, $response, $smsBatch): void
    {
        $this->collection->count() > 1 ?: $response = [$response];
        event(new SmsSentAgain($this->collection, json_decode(json_encode($response), true), $payload, $this->config, $smsBatch));
    }

    protected function createExtra($category, $uniqueCode): array
    {
        $extra ['is_admin'] = $this->isAdmin;
        $extra ['is_systematic'] = $this->isSystematic;
        $extra ['category'] = $category;
        $extra ['operator'] = 'rahyab_advertise';
        $extra ['code'] = $uniqueCode;
        $extra ['messagePattern'] = $this->messagePattern;
        $extra['className'] = $this->collection->isEmpty() ? null : getNamespaceMap($this->collection->first());
        return $extra;
    }

    private function setIsAdminAndIsSystematicInConfig(): void
    {
        $this->config['is_admin'] = $this->isAdmin;
        $this->config['is_systematic'] = $this->isSystematic;
    }
}

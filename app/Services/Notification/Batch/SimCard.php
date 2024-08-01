<?php

    namespace App\Services\Notification\Batch;

    use App\Models\SmsBatch;
    use App\Services\Notification\Events\SmsSent;
    use App\Services\Notification\Events\SmsSentAgain;
    use App\Services\Notification\MessagePattern\Pattern;
    use Illuminate\Support\Collection;
    use Illuminate\Database\Eloquent\Model;

    class SimCard
    {

        protected Collection $collection;
        protected array $config;
        protected Pattern $messagePatternClass;
        protected string $messagePattern;
        protected array $payload;
        protected bool $isAdmin = false;
        protected bool $isSystematic = false;

        public function __construct( $message , Collection $collection , string $category , $uniqueCode )
        {

            $this->collection = $collection;
            $this->messagePatternClass = new Pattern( $message );
            $this->messagePattern = $this->messagePatternClass->getPattern();
            $this->config = array_merge( $this->createExtra( $category , $uniqueCode ) , config( 'notification.drivers.simcard' ) );

            if ( isset( $this->config[ 'operator' ] ) ) {
                $this->config[ 'type' ] = 'simcard';
            }

            $this->client = new \SoapClient( $this->config[ 'url' ] , array( 'trace' => 1 ) );
        }

        public function isSystematic( $isSystematic = 0 ): static
        {
            $this->isSystematic = $isSystematic;
            return $this;
        }

        public function isAdmin( $isAdmin = 0 ): static
        {
            $this->isAdmin = $isAdmin;
            return $this;
        }

        public function send( $userData ): void
        {
            if ( $this->collection->count() <= config( 'notification.max_phone_size.do_send_sms_array_c' ) ) {
                $this->setIsAdminAndIsSystematicInConfig();
                $payload = $this->payload( $userData );
                $response = $this->client->SendSMS( $payload[ 'from' ] , $payload[ 'numbers' ] , $payload[ 'messages' ] , $payload[ 'username' ] , $payload[ 'password' ] , $payload[ 'time' ] , $payload[ 'op' ] );
                $response = json_decode( $response );
                $this->serializeToDatabase( json_decode( $response[ count( $response ) - 1 ] )[ 1 ] );
            }
        }

        public function sendAgain( $userData , SmsBatch $smsBatch ): void
        {
            if ( $this->collection->count() <= config( 'notification.max_phone_size.do_send_sms_array_c' ) ) {
                $payload = $this->payload( $userData );
                $response = $this->client->SendSMS( $payload[ 'from' ] , $payload[ 'numbers' ] , $payload[ 'messages' ] , $payload[ 'username' ] , $payload[ 'password' ] , $payload[ 'time' ] , $payload[ 'op' ] );
                $response = json_decode( $response );
                $this->updateToDatabase( $response , $smsBatch );
            }
        }

        protected function payload( $userData ): array
        {
            $data = [
                'username' => $this->config[ 'username' ] ,
                'password' => $this->config[ 'password' ] ,
                'from' => $this->config[ 'from' ] ,
                'op' => "pointtopoint" ,
                'time' => '' ,
            ];

            foreach ( $this->collection as $key => $item ) {
                $modelData = $this->prepareData( $item , $userData );
                $this->payload[] = $modelData;
                $data[ 'numbers' ][] = $modelData[ 'Cellphone' ];
                $data[ 'messages' ][] = $modelData[ 'Message' ];
            }

            return $data;
        }

        protected function prepareData( Model $model , $userData ): array
        {
            $fillable = is_null( $userData ) ? $model : $userData;
            return [
                'Cellphone' => $model->getPhone() ,
                'Message' => $this->messagePatternClass->fill( $fillable ) ,
            ];
        }

        protected function serializeToDatabase( $response ): void
        {
            $response = $this->prepareResponse( $response );
            event( new SmsSent( $this->collection , json_decode( json_encode( $response ) , true ) , $this->payload , $this->config ) );
        }


        protected function updateToDatabase( $response , $smsBatch ): void
        {
            $response = $this->prepareResponse( $response );
            event( new SmsSentAgain( $this->collection , json_decode( json_encode( $response ) , true ) , $this->payload , $this->config , $smsBatch ) );
        }

        protected function prepareResponse( $response ): array
        {
            $result = [];
            foreach ( $response as $value ) {
                $result[] = [
                    'ClientID' => null ,
                    'ServerID' => is_numeric( $value ) ? $value : -1 ,
                    'Status' => is_numeric( $value ) ? 'Send OK.' : $value ,
                ];
            }
            return $result;
        }

        protected function createExtra( $category , $uniqueCode ): array
        {
            $extra [ 'is_admin' ] = $this->isAdmin;
            $extra [ 'is_systematic' ] = $this->isSystematic;
            $extra [ 'category' ] = $category;
            $extra [ 'operator' ] = 'simcard';
            $extra [ 'code' ] = $uniqueCode;
            $extra [ 'messagePattern' ] = $this->messagePattern;
            $extra [ 'className' ] = $this->collection->isEmpty() ? null : getNamespaceMap( $this->collection->first() );
            return $extra;
        }

        private function setIsAdminAndIsSystematicInConfig(): void
        {
            $this->config[ 'is_admin' ] = $this->isAdmin;
            $this->config[ 'is_systematic' ] = $this->isSystematic;
        }
    }

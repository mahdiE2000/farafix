<?php

    namespace App\Services\Notification\Batch;

    use Illuminate\Support\Collection;

    class BatchTransmitter
    {

        protected Collection $collection;
        protected mixed $config;
        protected $message;

        public function __construct( Collection $collection )
        {
            $this->collection = $collection;
            $this->config = config( 'notification.drivers.rahyab_advertise' );
            $this->client = new \SoapClient( $this->config[ 'url' ] );
        }

        public function send( string $message )
        {
            $this->message = $message;
            if ( $this->collection->count() <= config( 'notification.max_phone_size.do_send_sms' ) ) {
                return $result = $this->client->doSendSMS( $this->payload() );
            }
        }

        protected function getPhones()
        {
            $phones = [];
            foreach ( $this->collection as $key => $item ) {
                $phones[] = $item->getPhone();
            }
            return array_unique( $phones );
        }

        protected function payload()
        {
            return array(
                'uUsername' => $this->config[ 'username' ] ,
                'uPassword' => $this->config[ 'password' ] ,
                'uNumber' => $this->config[ 'from' ] ,
                'uCellphones' => implode( ';' , $this->getPhones() ) ,
                'uMessage' => $this->message ,
                'uFarsi' => true ,
                'uTopic' => false ,
                'uFlash' => false ,
                'uUDH' => ''
            );
        }
    }

<?php

    namespace App\Services\Notification;

    use App\Models\SmsBatch;
    use App\Services\Notification\Batch\PeerToPeer;
    use App\Services\Notification\Batch\SimCard;
    use Illuminate\Support\Str;

    class SmsNotification
    {

        protected $builder;
        protected string $category;
        protected $userData;
        protected bool $isSystematic = false;
        protected bool $isAdmin = false;

        protected static $self = null;

        private function __construct( $builder , $userData )
        {
            $this->builder = $builder;
            $this->userData = $userData;
            $this->category = $this->builder->limit( 2 )->count() > 1 ? 'batch' : 'single';

        }

        public function setBuilder( $builder ): static
        {
            $this->builder = $builder;
            $this->category = $this->builder->limit( 2 )->count() > 1 ? 'batch' : 'single';
            return $this;
        }

        public function setUserData( $userData ): static
        {
            $this->userData = $userData;
            return $this;
        }

        public static function to( $builder , $userData = null )
        {
            if ( static::$self === null ) {
                static::$self = new static( $builder , $userData );
            }
            return static::$self;
        }

        public function isSystematic(): static
        {
            $this->isSystematic = true;
            return $this;
        }

        public function isAdmin(): static
        {
            $this->isAdmin = true;
            return $this;
        }

        public function sendAgain( SmsBatch $smsBatch ): void
        {
            $uniqueCode = Str::random( 40 );
            foreach ( $this->chuncks() as $notification ) {
                switch ( $smsBatch->type ) {
                    case 'advertise':
                        ( new PeerToPeer( $smsBatch->pattern , $notification , $this->category , $uniqueCode ) )->isAdmin( $this->isAdmin )->isSystematic( $this->isSystematic )->sendAgain( $this->userData , $smsBatch );
                        break;
                    case 'simcard'  :
                        ( new SimCard( $smsBatch->pattern , $notification , $this->category , $uniqueCode ) )->isAdmin( $this->isAdmin )->isSystematic( $this->isSystematic )->sendAgain( $this->userData , $smsBatch );
                        break;
                    case 'service':
                        ( new PeerToPeer( $smsBatch->pattern , $notification , $this->category , $uniqueCode , 'service' ) )->isAdmin( $this->isAdmin )->isSystematic( $this->isSystematic )->sendAgain( $this->userData , $smsBatch );
                        break;
                }
            }
        }

        public function send( $message , $method = 'advertise' ): void
        {
            $uniqueCode = Str::random( 40 );
            foreach ( $this->chuncks() as $notification ) {
                switch ( $method ) {
                    case 'advertise':
                        ( new PeerToPeer( $message , $notification , $this->category , $uniqueCode ) )->isAdmin( $this->isAdmin )->isSystematic( $this->isSystematic )->send( $this->userData );
                        break;
                    case 'simcard'  :
                        ( new SimCard( $message , $notification , $this->category , $uniqueCode ) )->isAdmin( $this->isAdmin )->isSystematic( $this->isSystematic )->send( $this->userData );
                        break;
                    case 'service':
                        ( new PeerToPeer( $message , $notification , $this->category , $uniqueCode , 'service' ) )->isAdmin( $this->isAdmin )->isSystematic( $this->isSystematic )->send( $this->userData );
                        break;
                }
            }
        }

        public function sendWithTemplate( $template ): void
        {
            if ( ! is_null( $template ) ) {
                $this->send( $template->template , $template->operator );
            }
        }

        protected function chuncks(): \Generator
        {
            $limit = config( 'notification.max_phone_size.do_send_sms_array_c' );
            $iteration = 0;
            while ( true ) {
                $offset = $iteration * $limit;
                $chunk = $this->builder->offset( $offset )->limit( $limit )->get();
                if ( $chunk->isEmpty() ) {
                    break;
                }
                $iteration++;
                yield $chunk;
            }
        }

    }

<?php

    namespace App\Services\Notification\Events;

    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Queue\SerializesModels;

    class SmsSent
    {
        use SerializesModels;

        public Collection $collection;
        public array $response;
        public array $payload;
        public array $extra;

        /**
         * Create a new event instance.
         *
         * @param Collection $collection
         * @param array $response
         * @param array $payload
         * @param array $extra
         */
        public function __construct( Collection $collection , array $response , array $payload , array $extra )
        {
            $this->collection = $collection;
            $this->response = $response;
            $this->payload = $payload;
            $this->extra = $extra;
        }
    }

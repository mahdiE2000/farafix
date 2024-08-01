<?php

    namespace App\Services\Notification\Events;

    use App\Models\SmsBatch;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Queue\SerializesModels;

    class SmsSentAgain
    {
        use SerializesModels;

        public Collection $collection;
        public array $response;
        public array $payload;
        public array $extra;
        public SmsBatch $smsBatch;

        /**
         * Create a new event instance.
         *
         * @param Collection $collection
         * @param array $response
         * @param array $payload
         * @param array $extra
         * @param SmsBatch $smsBatch
         */
        public function __construct( Collection $collection , array $response , array $payload , array $extra , SmsBatch $smsBatch )
        {
            $this->collection = $collection;
            $this->response = $response;
            $this->payload = $payload;
            $this->extra = $extra;
            $this->smsBatch = $smsBatch;
        }
    }

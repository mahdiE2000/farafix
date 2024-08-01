<?php

    namespace App\Exceptions;

    class ValidationErrorException extends \Exception
    {

        protected array $data;
        protected array $body;

        public function __construct( string $message , array $body = [] , array $data = [] )
        {
            parent::__construct( $message );
            $this->data = $data;
            $this->body = $body;
        }

        public function getMessageInfo(): array
        {
            return $this->data;
        }

        public function getMessageBody(): array
        {
            return $this->body;
        }
    }

<?php

    namespace App\Repositories;

    interface RequestRepositoryInterface
    {
        public function destroy( int $requestId );

        public function index();

        public function indexMyRequests();

        public function show( int $requestId );

        public function store( array $data );

        public function storeMyRequest( array $data );

        public function update( array $data , int $requestId );

        public function updateMyRequest( array $data , int $requestId );

        public function changeStatus( string $status , int $requestId );

        public function countSuspended();
    }

<?php

    namespace App\Repositories;

    interface CityRepositoryInterface
    {
        public function index( $type );

        public function indexProvince();

        public function showProvince( $cityId );

        public function show( $cityId );
    }

<?php

    namespace App\Repositories\Eloquent;

    use App\Models\City;
    use App\Repositories\CityRepositoryInterface;

    class CityRepository implements CityRepositoryInterface
    {

        public function index( $type )
        {
            return City::where( 'view' , $type )->get( [ 'id' , 'name_fa' , 'name_en' ] );
        }

        public function indexProvince()
        {
            return City::whereNull( 'parent_id' )->get( [ 'id' , 'name_fa' , 'name_en' ] );
        }

        public function showProvince( $cityId )
        {
            return City::with( 'cities' )->findOrFail( $cityId );
        }

        public function show( $cityId )
        {
            return City::findOrFail( $cityId );
        }
    }

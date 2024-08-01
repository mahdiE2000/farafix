<?php

    namespace App\Http\Controllers\City;

    use App\Http\Controllers\Controller;
    use App\Http\Resources\CityResource;
    use App\Repositories\CityRepositoryInterface;

    class ShowProvince extends Controller
    {
        public function __invoke( $province ): CityResource
        {
            $cities = app( CityRepositoryInterface::class )->showProvince( $province );
            return CityResource::make( $cities );
        }
    }

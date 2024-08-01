<?php

    namespace App\Http\Controllers\City;

    use App\Http\Controllers\Controller;
    use App\Http\Resources\CityResource;
    use App\Models\City;
    use App\Repositories\CityRepositoryInterface;

    class ShowCity extends Controller
    {
        public function __invoke( City $city ): CityResource
        {
            $city = app( CityRepositoryInterface::class )->show( $city->id );
            return new CityResource( $city );
        }
    }

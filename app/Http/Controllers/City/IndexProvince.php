<?php

    namespace App\Http\Controllers\City;

    use App\Http\Controllers\Controller;
    use App\Http\Resources\CityResource;
    use App\Repositories\CityRepositoryInterface;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

    class IndexProvince extends Controller
    {
        public function __invoke(): AnonymousResourceCollection
        {
            $cities = app( CityRepositoryInterface::class )->indexProvince();

            return CityResource::collection( $cities );
        }
    }

<?php

    namespace App\Http\Controllers\City;

    use App\Http\Resources\CityResource;
    use App\Repositories\CityRepositoryInterface;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

    class IndexCity extends Controller
    {
        public function __invoke( Request $request ): AnonymousResourceCollection
        {
            $type = $request->input( 'type' ) ?? 1;
            $cities = app( CityRepositoryInterface::class )->index( $type );
            return CityResource::collection( $cities );
        }
    }

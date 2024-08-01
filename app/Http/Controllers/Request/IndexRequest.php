<?php

    namespace App\Http\Controllers\Request;

    use App\Http\Controllers\Controller;
    use App\Http\Resources\RequestResource;
    use App\Repositories\RequestRepositoryInterface;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

    class IndexRequest extends Controller
    {

        public function __invoke(): AnonymousResourceCollection
        {
            return RequestResource::collection(
                app( RequestRepositoryInterface::class )->index()
            );
        }

        public function IndexMyRequests(): AnonymousResourceCollection
        {
            return RequestResource::collection(
                app( RequestRepositoryInterface::class )->indexMyRequests()
            );
        }

        public function IndexDeviceCategory()
        {
            return config( "devices.categories" );
        }

    }

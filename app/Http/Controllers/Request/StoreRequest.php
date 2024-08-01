<?php

    namespace App\Http\Controllers\Request;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Request\CreateRequestRequest;
    use App\Http\Resources\RequestResource;
    use App\Repositories\RequestRepositoryInterface;

    class StoreRequest extends Controller
    {

        public function __invoke( CreateRequestRequest $createRequestRequest ): RequestResource
        {
            $this->validate($createRequestRequest, [
                'user_id' => 'required|numeric|exists:users,id',
            ]);
            return RequestResource::make(
                app(RequestRepositoryInterface::class)->store($createRequestRequest->only([ 'device_title' , 'device_category_id' , 'user_id' , 'description' , 'address.city_id' , 'address.postal_code' , 'address.phone' , 'address.address']))
            );
        }

        public function StoreMyRequest( CreateRequestRequest $createRequestRequest ): RequestResource
        {
            return RequestResource::make(
                app(RequestRepositoryInterface::class)->storeMyRequest($createRequestRequest->validated())
            );
        }

    }

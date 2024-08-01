<?php

    namespace App\Http\Controllers\Request;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Request\UpdateRequestRequest;
    use App\Http\Resources\RequestResource;
    use App\Models\Request;
    use App\Repositories\RequestRepositoryInterface;

    class UpdateRequest extends Controller
    {

        public function __invoke( Request $request , UpdateRequestRequest $updateRequestRequest ): RequestResource
        {
            $this->validate($updateRequestRequest, [
                'user_id' => 'required|numeric|exists:users,id',
            ]);
            return RequestResource::make(
                app( RequestRepositoryInterface::class )->update( $updateRequestRequest->only([ 'device_title' , 'device_category_id' , 'user_id' , 'description' , 'address.city_id' , 'address.postal_code' , 'address.phone' , 'address.address']) , $request->id )
            );
        }

        public function UpdateMyRequest( Request $request , UpdateRequestRequest $updateRequestRequest ): RequestResource
        {
            return RequestResource::make(
                app( RequestRepositoryInterface::class )->updateMyRequest( $updateRequestRequest->validated() , $request->id )
            );
        }

    }

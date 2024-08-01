<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\ValidationErrorException;
use App\Models\Request;
use App\Models\User;
use App\Repositories\RequestRepositoryInterface;
use App\Services\AddressManager;
use App\Services\Notification\SmsNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class RequestRepository implements RequestRepositoryInterface
{
    public function destroy( $requestId )
    {
        $request = Request::findOrFail( $requestId );
        AddressManager::destroy( $request );
        return $request->delete();
    }

    public function index(): LengthAwarePaginator
    {
        return Request::with( [ "address" , "user" ] )->filtered()->paginate();
    }

    public function indexMyRequests()
    {
        return Request::where( "user_id" , auth()->id() )->with( [ "address" , "user" ] )->filtered()->paginate();
    }

    public function show( $requestId )
    {
        $request = Request::findOrFail( $requestId );
        $request->load( [ "address" , "user" ] );
        return $request;
    }

    public function store( $data ): Model|Builder
    {
        $addressData = Arr::get( $data , 'address' , [] );
        unset( $data[ "address" ] );

        $request = Request::query()->create( $data );
        AddressManager::create( $addressData , $request );

        $request->load( [ "address" , "user" ] );
        return $request;
    }

    public function storeMyRequest( $data ): Model|Builder
    {
        $addressData = Arr::get( $data , 'address' , [] );
        unset( $data[ "address" ] );

        $data[ "user_id" ] = auth()->id();
        $request = Request::query()->create( $data );
        AddressManager::create( $addressData , $request );

        $request->load( [ "address" , "user" ] );
        return $request;
    }

    public function update( $data , $requestId )
    {
        $addressData = Arr::get( $data , 'address' , [] );
        unset( $data[ "address" ] );

        $request = Request::findOrFail( $requestId );
        $request->update( $data );
        AddressManager::destroy( $request );
        AddressManager::create( $addressData , $request );

        $request->load( [ "address" , "user" ] );
        return $request;
    }

    public function updateMyRequest( $data , $requestId )
    {
        $addressData = Arr::get( $data , 'address' , [] );
        unset( $data[ "address" ] );

        $data[ "user_id" ] = auth()->id();
        $request = Request::findOrFail( $requestId );
        $request->update( $data );
        AddressManager::destroy( $request );
        AddressManager::create( $addressData , $request );

        $request->load( [ "address" , "user" ] );
        return $request;
    }

    public function changeStatus( $status , $requestId )
    {
        $request = Request::findOrFail( $requestId );
        $userCollection = User::query()->where( 'id' , $request->user_id );
        if ( $status == 'approved' ) {
            $request->update( [
                'status' => 'approved'
            ] );
            SmsNotification::to( $userCollection )->isSystematic()->send(
                "کاربر گرامی، درخواست شما مربوط به دستگاه "
                . $request->device_title .
                " تایید شد." ,
                'service'
            );
        } elseif ( $status == 'rejected' ) {
            $request->update( [
                'status' => 'rejected'
            ] );
            SmsNotification::to( $userCollection )->isSystematic()->send(
                "کاربر گرامی، درخواست شما مربوط به دستگاه "
                . $request->device_title .
                " رد شد." ,
                'service'
            );
        } else {
            throw new ValidationErrorException( 'The status is not correct' , [ 'err' => "The status that you sent is not correct" ] );
        }

        $request->save();
        $request->load( [ 'address' , "user" ] );
        return $request;
    }

    public function countSuspended()
    {
        return Request::where( "status" , "suspended" )->count();
    }
}

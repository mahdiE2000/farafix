<?php

namespace App\Repositories\Eloquent;


use App\Models\Error;
use App\Services\Media\MediaHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use http\Exception\InvalidArgumentException;
use App\Repositories\ErrorRepositoryInterface;

class ErrorRepository implements ErrorRepositoryInterface
{
    public function destroy( $errorId )
    {
        $error = Error::findOrFail( $errorId );
        return $error->delete();
    }

    public function all()
    {
        return Error::filtered()->get();
    }

    public function index()
    {
        return Error::filtered()->paginate();
    }

    public function indexOnline()
    {
        return Error::paginate();
    }

    public function show( $errorId )
    {
        $error = Error::findOrFail( $errorId );
        $error->load( [ "errorBrand" , "errorCategory" ,"errorItems" , "errorItems.errorCodes" ] );
        return $error;
    }

    public function showOnline( $errorId )
    {
        $error = Error::findOrFail( $errorId );
        $error->load( [ "errorItems" , "errorItems.errorCodes" ] );
        return $error;
    }

    public function showOnlineByName( $errorName )
    {
        $error = Error::where( "name" , $errorName )->first();

        if (! $error){
            throw new InvalidArgumentException("The name is not exists");
        }

        $error->load( [ "errorItems" , "errorItems.errorCodes" ] );
        return $error;
    }

    public function store( $data ): Model|Builder
    {
        $error = Error::query()->create( $data );

        MediaHelper::storeMediaFor($error);

        $error->load( [ "errorItems" ] );
        return $error;
    }

    public function update( array $data , int $errorId )
    {
        $error = Error::findOrFail( $errorId );
        $error->update( $data );

        $error->load( [ "errorItems" ] );
        return $error;
    }
}

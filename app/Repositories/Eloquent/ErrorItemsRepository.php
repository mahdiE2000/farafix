<?php

namespace App\Repositories\Eloquent;

use App\Models\ErrorItem;
use App\Models\ErrorCode;
use App\Repositories\ErrorItemsRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ErrorItemsRepository implements ErrorItemsRepositoryInterface
{
    public function destroy( $errorItemId )
    {
        $errorItem = ErrorItem::findOrFail( $errorItemId );
        foreach ( $errorItem->errorCodes as $errorCodes ) {
            $errorCodes->delete();
        }
        return $errorItem->delete();
    }

    public function index()
    {
        return ErrorItem::with( [ "errorCodes" , "error" ] )->filtered()->paginate();
    }

    public function indexOnline(): LengthAwarePaginator
    {
        return ErrorItem::with( [ "errorCodes" , "error" ] )->paginate();
    }

    public function show( $errorItemId )
    {
        $errorItem = ErrorItem::findOrFail( $errorItemId );
        $errorItem->load( [ "errorCodes" , "error" ] );
        return $errorItem;
    }

    public function showOnline( $errorItemId )
    {
        $errorItem = ErrorItem::findOrFail( $errorItemId );
        $errorItem->load( [ "errorCodes" , "error" ] );
        return $errorItem;
    }

    public function store( $data ): Model|Builder
    {
        $errorItem = ErrorItem::query()->create( Arr::except( $data , "codes" ) );

        if ( Arr::has( $data , "codes" ) ) {
            foreach ( $data[ "codes" ] as $errorCodes ) {
                $errorItem->errorCodes()->create( $errorCodes );
            }
        }

        $errorItem->load( [ "errorCodes" , "error" ] );
        return $errorItem;
    }

    public function update( array $data , int $errorItemId )
    {
        $errorItem = ErrorItem::findOrFail( $errorItemId );
        $errorItem->update( $data );
        if ( Arr::has( $data , "codes" ) ) {
            $errorItem->errorCodes()->delete();
            foreach ( $data[ "codes" ] as $errorCodes ) {
                $errorItem->errorCodes()->create($errorCodes);
            }
        }

        $errorItem->load( [ "errorCodes" , "error" ] );
        return $errorItem;
    }
}

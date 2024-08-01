<?php

namespace App\Http\Controllers\Error;

use App\Http\Controllers\Controller;
use App\Http\Resources\ErrorResource;
use App\Models\Error;
use App\Repositories\ErrorRepositoryInterface;
use Illuminate\Http\Request;

class ShowError extends Controller
{
    public function __invoke( Error $error ): ErrorResource
    {
        return ErrorResource::make(
            app( ErrorRepositoryInterface::class )->show( $error->id )
        );
    }

    public function show( Error $error ): ErrorResource
    {
        return ErrorResource::make(
            app( ErrorRepositoryInterface::class )->showOnline( $error->id )
        );
    }

    public function showByName( $name ): ErrorResource
    {
        return ErrorResource::make(
            app( ErrorRepositoryInterface::class )->showOnlineByName( $name )
        );
    }
}

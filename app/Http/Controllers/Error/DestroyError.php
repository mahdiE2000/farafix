<?php

namespace App\Http\Controllers\Error;

use App\Http\Controllers\Controller;
use App\Models\Error;
use App\Repositories\ErrorRepositoryInterface;
use App\Services\Responser;
use Illuminate\Http\JsonResponse;

class DestroyError extends Controller
{
    public function __invoke( Error $error ): JsonResponse
    {
        app( ErrorRepositoryInterface::class )->destroy( $error->id );
        return response()->json( Responser::success() );
    }
}

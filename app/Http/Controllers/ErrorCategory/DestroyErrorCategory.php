<?php

namespace App\Http\Controllers\ErrorCategory;

use App\Services\Responser;
use Illuminate\Http\Request;
use App\Models\ErrorCategory;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\ErrorCategoryRepository;
use Illuminate\Http\JsonResponse;

class DestroyErrorCategory extends Controller
{
    public function __invoke( ErrorCategory $errorCategory ): JsonResponse
    {
        app( ErrorCategoryRepository::class )->destroy( $errorCategory->id );
        return response()->json( Responser::success() );
    }
}

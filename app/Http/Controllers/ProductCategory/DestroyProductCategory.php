<?php

namespace App\Http\Controllers\ProductCategory;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Repositories\ProductCategoryRepositoryInterface;
use App\Services\Responser;
use Illuminate\Http\JsonResponse;

class DestroyProductCategory extends Controller
{
    public function __invoke( ProductCategory $productCategory ): JsonResponse
    {
        app( ProductCategoryRepositoryInterface::class )->destroy( $productCategory->id );
        return response()->json( Responser::success() );
    }
}

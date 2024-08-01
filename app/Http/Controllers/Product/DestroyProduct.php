<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;
use App\Services\Responser;
use Illuminate\Http\JsonResponse;

class DestroyProduct extends Controller
{
    public function __invoke( Product $product ): JsonResponse
    {
        app( ProductRepositoryInterface::class )->destroy( $product->id );
        return response()->json( Responser::success() );
    }
}

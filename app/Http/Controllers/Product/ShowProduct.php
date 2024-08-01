<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;

class ShowProduct extends Controller
{
    public function __invoke( Product $product ): ProductResource
    {
        return ProductResource::make(
            app( ProductRepositoryInterface::class )->show( $product->id )
        );
    }

    public function show( Product $product ): ProductResource
    {
        return ProductResource::make(
            app( ProductRepositoryInterface::class )->showOnline( $product->id )
        );
    }
}

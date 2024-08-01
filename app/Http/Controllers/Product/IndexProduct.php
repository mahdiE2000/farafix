<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IndexProduct extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        return ProductResource::collection(
            app( ProductRepositoryInterface::class )->index()
        );
    }

    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(
            app( ProductRepositoryInterface::class )->indexOnline()
        );
    }

    public function similar( Product $product ): AnonymousResourceCollection
    {
        return ProductResource::collection(
            app( ProductRepositoryInterface::class )->similarProducts( $product->id )
        );
    }
}

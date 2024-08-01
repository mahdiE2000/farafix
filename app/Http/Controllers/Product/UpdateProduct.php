<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;

class UpdateProduct extends Controller
{
    public function __invoke( Product $product , UpdateProductRequest $updateProductRequest ): ProductResource
    {
        return ProductResource::make(
            app( ProductRepositoryInterface::class )->update(
                $updateProductRequest->only( [ 'title' , 'summary' , 'category_id' , 'description' ] ),
                $product->id
            )
        );
    }
}

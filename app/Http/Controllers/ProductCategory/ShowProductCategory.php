<?php

namespace App\Http\Controllers\ProductCategory;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use App\Repositories\ProductCategoryRepositoryInterface;

class ShowProductCategory extends Controller
{
    public function __invoke( ProductCategory $productCategory ): ProductCategoryResource
    {
        return ProductCategoryResource::make(
            app( ProductCategoryRepositoryInterface::class )->show( $productCategory->id )
        );
    }

    public function show( ProductCategory $productCategory ): ProductCategoryResource
    {
        return ProductCategoryResource::make(
            app( ProductCategoryRepositoryInterface::class )->show( $productCategory->id )
        );
    }
}

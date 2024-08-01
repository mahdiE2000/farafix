<?php

namespace App\Http\Controllers\ProductCategory;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryResource;
use App\Repositories\ProductCategoryRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IndexProductCategory extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        return ProductCategoryResource::collection(
            app( ProductCategoryRepositoryInterface::class )->index()
        );
    }

    public function index(): AnonymousResourceCollection
    {
        return ProductCategoryResource::collection(
            app( ProductCategoryRepositoryInterface::class )->index()
        );
    }

    public function All(): AnonymousResourceCollection
    {
        return ProductCategoryResource::collection(
            app( ProductCategoryRepositoryInterface::class )->all()
        );
    }
}

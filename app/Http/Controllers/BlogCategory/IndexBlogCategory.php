<?php

namespace App\Http\Controllers\BlogCategory;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogCategoryResource;
use App\Repositories\BlogCategoryRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IndexBlogCategory extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        return BlogCategoryResource::collection(
            app( BlogCategoryRepositoryInterface::class )->index()
        );
    }

    public function index(): AnonymousResourceCollection
    {
        return BlogCategoryResource::collection(
            app( BlogCategoryRepositoryInterface::class )->index()
        );
    }

    public function All(): AnonymousResourceCollection
    {
        return BlogCategoryResource::collection(
            app( BlogCategoryRepositoryInterface::class )->all()
        );
    }
}

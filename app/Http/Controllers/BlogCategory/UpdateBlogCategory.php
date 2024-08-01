<?php

namespace App\Http\Controllers\BlogCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategory\UpdateBlogCategoryRequest;
use App\Http\Resources\BlogCategoryResource;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepositoryInterface;

class UpdateBlogCategory extends Controller
{
    public function __invoke(BlogCategory $blogCategory, UpdateBlogCategoryRequest $updateBlogCategoryRequest): BlogCategoryResource
    {
        return BlogCategoryResource::make(
            app(BlogCategoryRepositoryInterface::class)->update(
                $updateBlogCategoryRequest->validated(),
                $blogCategory->id
            )
        );
    }
}

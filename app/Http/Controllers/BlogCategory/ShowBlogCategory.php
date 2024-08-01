<?php

namespace App\Http\Controllers\BlogCategory;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogCategoryResource;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepositoryInterface;

class ShowBlogCategory extends Controller
{
    public function __invoke( BlogCategory $blogCategory ): BlogCategoryResource
    {
        return BlogCategoryResource::make(
            app( BlogCategoryRepositoryInterface::class )->show( $blogCategory->id )
        );
    }

    public function show( BlogCategory $blogCategory ): BlogCategoryResource
    {
        return BlogCategoryResource::make(
            app( BlogCategoryRepositoryInterface::class )->show( $blogCategory->id )
        );
    }
}

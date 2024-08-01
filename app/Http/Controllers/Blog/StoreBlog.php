<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\CreateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Repositories\BlogRepositoryInterface;

class StoreBlog extends Controller
{
    public function __invoke( CreateBlogRequest $createBlogRequest ): BlogResource
    {
        return BlogResource::make(
            app( BlogRepositoryInterface::class )->store(
                $createBlogRequest->only( [ 'title' , 'summary' , 'category_id' , 'description' ] )
            )
        );
    }
}

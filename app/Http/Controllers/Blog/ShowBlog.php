<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Repositories\BlogRepositoryInterface;

class ShowBlog extends Controller
{
    public function __invoke( Blog $blog ): BlogResource
    {
        return BlogResource::make(
            app( BlogRepositoryInterface::class )->show( $blog->id )
        );
    }

    public function show( Blog $blog ): BlogResource
    {
        return BlogResource::make(
            app( BlogRepositoryInterface::class )->showOnline( $blog->id )
        );
    }
}

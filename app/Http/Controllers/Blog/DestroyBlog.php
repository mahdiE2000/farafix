<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Repositories\BlogRepositoryInterface;
use App\Services\Responser;
use Illuminate\Http\JsonResponse;

class DestroyBlog extends Controller
{
    public function __invoke( Blog $blog ): JsonResponse
    {
        app( BlogRepositoryInterface::class )->destroy( $blog->id );
        return response()->json( Responser::success() );
    }
}

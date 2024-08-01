<?php

namespace App\Http\Controllers\BlogCategory;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepositoryInterface;
use App\Services\Responser;
use Illuminate\Http\JsonResponse;

class DestroyBlogCategory extends Controller
{
    public function __invoke( BlogCategory $blogCategory ): JsonResponse
    {
        app( BlogCategoryRepositoryInterface::class )->destroy( $blogCategory->id );
        return response()->json( Responser::success() );
    }
}

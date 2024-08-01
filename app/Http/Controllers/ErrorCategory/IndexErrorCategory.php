<?php

namespace App\Http\Controllers\ErrorCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ErrorCategoryResource;
use App\Repositories\ErrorCategoryRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IndexErrorCategory extends Controller
{
    public function __invoke()
    {
        return ErrorCategoryResource::collection(
            app( ErrorCategoryRepositoryInterface::class )->index()
        );
    }

    public function All(): AnonymousResourceCollection
    {
        return ErrorCategoryResource::collection(
            app( ErrorCategoryRepositoryInterface::class )->all()
        );
    }
}

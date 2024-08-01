<?php

namespace App\Http\Controllers\ErrorCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ErrorCategoryResource;
use App\Repositories\ErrorCategoryRepositoryInterface;
use App\Http\Requests\ErrorCategory\CreateErrorCategoryRequest;


class StoreErrorCategory extends Controller
{
    public function __invoke(CreateErrorCategoryRequest $createErrorCategoryRequest)
    {
        return ErrorCategoryResource::make(
            app( ErrorCategoryRepositoryInterface::class )->store(
                $createErrorCategoryRequest->only(['name','name_en'])
            )
        );
    }
}

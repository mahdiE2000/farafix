<?php

namespace App\Http\Controllers\ErrorCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ErrorCategoryResource;
use App\Repositories\ErrorCategoryRepositoryInterface;
use App\Models\ErrorCategory;

class ShowErrorCategory extends Controller
{
    public function __invoke(ErrorCategory $errorCategory)
    {
        return ErrorCategoryResource::make(
            app( ErrorCategoryRepositoryInterface::class )->show($errorCategory->id)
        );
    }

}

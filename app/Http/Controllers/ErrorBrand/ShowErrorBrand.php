<?php

namespace App\Http\Controllers\ErrorBrand;

use App\Models\ErrorBrand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ErrorBrandResource;
use App\Repositories\ErrorBrandRepositoryInterface;

class ShowErrorBrand extends Controller
{
    public function __invoke(ErrorBrand $errorBrand)
    {
        return ErrorBrandResource::make(
            app( ErrorBrandRepositoryInterface::class )->show($errorBrand->id)
        );
    }
}

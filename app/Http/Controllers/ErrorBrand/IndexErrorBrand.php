<?php

namespace App\Http\Controllers\ErrorBrand;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ErrorBrandResource;
use App\Repositories\ErrorBrandRepositoryInterface;

class IndexErrorBrand extends Controller
{
    public function __invoke()
    {
        return ErrorBrandResource::collection(
            app( ErrorBrandRepositoryInterface::class )->index()
        );
    }
}

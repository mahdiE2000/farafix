<?php

namespace App\Repositories\Eloquent;
use App\Repositories\ErrorBrandRepositoryInterface;
use App\Models\ErrorBrand;

class ErrorBrandRepository implements ErrorBrandRepositoryInterface
{
    public function index()
    {
        return ErrorBrand::get();
    }

    public function show( $errorBrandId )
    {
        $errorBrand = ErrorBrand::findOrFail( $errorBrandId );
        $errorBrand->load( 'errorCategories' );
        return $errorBrand;
    }

}

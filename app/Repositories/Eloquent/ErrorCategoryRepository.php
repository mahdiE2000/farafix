<?php

namespace App\Repositories\Eloquent;
use App\Repositories\ErrorCategoryRepositoryInterface;
use App\Models\ErrorCategory;

class ErrorCategoryRepository implements ErrorCategoryRepositoryInterface
{

    public function all()
    {
        return ErrorCategory::with('errorBrands')->filtered()->get();
    }

    public function index()
    {
        return ErrorCategory::with( 'errorBrands' )->filtered()->paginate();
    }

    public function show( $errorCategoryId )
    {
        $error = ErrorCategory::findOrFail( $errorCategoryId );
        $error->load( 'errorBrands' );
        return $error;
    }

    public function store($data)
    {
        $error = ErrorCategory::query()->create( $data );
        return $error;
    }

    public function destroy(int $errorCategoryId){
        $errorCategory = ErrorCategory::findOrFail( $errorCategoryId );
        return $errorCategory->delete();
    }


}

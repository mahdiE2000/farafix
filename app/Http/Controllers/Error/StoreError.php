<?php

namespace App\Http\Controllers\Error;

use App\Http\Controllers\Controller;
use App\Http\Requests\Error\CreateErrorRequest;
use App\Http\Resources\ErrorResource;
use App\Repositories\ErrorRepositoryInterface;

class StoreError extends Controller
{
    public function __invoke( CreateErrorRequest $createErrorRequest ): ErrorResource
    {
        return ErrorResource::make(
            app( ErrorRepositoryInterface::class )->store(
                $createErrorRequest->only( [ 'name' , 'title' , 'title_en' , 'date' , 'description','category_id','brand_id' ] )
            )
        );
    }
}

<?php

namespace App\Http\Controllers\Error;

use App\Http\Controllers\Controller;
use App\Http\Requests\Error\UpdateErrorRequest;
use App\Http\Resources\ErrorResource;
use App\Models\Error;
use App\Repositories\ErrorRepositoryInterface;

class UpdateError extends Controller
{
    public function __invoke( Error $error , UpdateErrorRequest $updateErrorRequest ): ErrorResource
    {
        return ErrorResource::make(
            app( ErrorRepositoryInterface::class )->update(
                $updateErrorRequest->only( [ 'name' , 'title' , 'title_en' , 'date' , 'description','category_id','brand_id' ] ),
                $error->id
            )
        );
    }
}

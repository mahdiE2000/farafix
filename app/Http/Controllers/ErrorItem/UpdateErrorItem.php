<?php

namespace App\Http\Controllers\ErrorItem;

use App\Http\Controllers\Controller;
use App\Http\Requests\ErrorItem\UpdateErrorItemRequest;
use App\Http\Resources\ErrorItemResource;
use App\Models\ErrorItem;
use App\Repositories\ErrorItemsRepositoryInterface;

class UpdateErrorItem extends Controller
{
    public function __invoke( ErrorItem $errorItem , UpdateErrorItemRequest $updateErrorItemRequest ): ErrorItemResource
    {
        return ErrorItemResource::make(
            app( ErrorItemsRepositoryInterface::class )->update(
                $updateErrorItemRequest->only( ['name', 'title' , 'title_en' , 'summary' , 'error_id' , 'description','codes' ] ),
                $errorItem->id
            )
        );
    }
}

<?php

namespace App\Http\Controllers\ErrorItem;

use App\Http\Controllers\Controller;
use App\Http\Requests\ErrorItem\CreateErrorItemRequest;
use App\Http\Resources\ErrorItemResource;
use App\Repositories\ErrorItemsRepositoryInterface;

class StoreErrorItem extends Controller
{
    public function __invoke(CreateErrorItemRequest $createErrorItemRequest): ErrorItemResource
    {
        return ErrorItemResource::make(
            app(ErrorItemsRepositoryInterface::class)->store(
                $createErrorItemRequest->only(['name','title', 'title_en', 'error_id', 'summary', 'description', 'codes'])
            )
        );
    }
}

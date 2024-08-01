<?php

namespace App\Http\Controllers\Error;

use App\Http\Controllers\Controller;
use App\Http\Resources\ErrorResource;
use App\Repositories\ErrorRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IndexError extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        return ErrorResource::collection(
            app( ErrorRepositoryInterface::class )->index()
        );
    }

    public function index(): AnonymousResourceCollection
    {
        return ErrorResource::collection(
            app( ErrorRepositoryInterface::class )->index()
        );
    }

    public function All(): AnonymousResourceCollection
    {
        return ErrorResource::collection(
            app( ErrorRepositoryInterface::class )->all()
        );
    }
}

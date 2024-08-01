<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Repositories\RequestRepositoryInterface;
use App\Services\Responser;

class CountSuspended extends Controller
{
    public function __invoke()
    {
        return response()->json(
            Responser::data( app( RequestRepositoryInterface::class )->countSuspended() )
        );
    }
}

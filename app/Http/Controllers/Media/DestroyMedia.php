<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Services\Media\Media;
use App\Services\Responser;
use Illuminate\Http\JsonResponse;

class DestroyMedia extends Controller
{
    public function __invoke(Media $media): JsonResponse
    {
        $media->delete();
        return response()->json(Responser::success());
    }
}

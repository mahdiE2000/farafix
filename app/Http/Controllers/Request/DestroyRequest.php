<?php

    namespace App\Http\Controllers\Request;

    use App\Http\Controllers\Controller;
    use App\Models\Request;
    use App\Repositories\RequestRepositoryInterface;
    use App\Services\Responser;
    use Illuminate\Http\JsonResponse;

    class DestroyRequest extends Controller
    {

        public function __invoke( Request $request ): JsonResponse
        {
            app( RequestRepositoryInterface::class )->destroy( $request->id );
            return response()->json( Responser::success() );
        }

    }

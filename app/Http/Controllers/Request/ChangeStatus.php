<?php

    namespace App\Http\Controllers\Request;

    use App\Http\Controllers\Controller;
    use App\Http\Resources\RequestResource;
    use App\Models\Request;
    use Illuminate\Http\Request as Data;
    use App\Repositories\RequestRepositoryInterface;

    class ChangeStatus extends Controller
    {

        public function __invoke( Request $request , Data $data): RequestResource
        {
            return RequestResource::make(
                app( RequestRepositoryInterface::class )->changeStatus( $data->status , $request->id )
            );
        }

    }

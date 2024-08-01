<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Services\Responser;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\DB;

    class LogoutHandler extends Controller
    {

        public function __invoke(): JsonResponse
        {
            $accessToken = auth( 'api' )->user()->token();
            DB::table( 'oauth_access_tokens' )->where( 'id' , $accessToken->id )->delete();
            DB::table( 'oauth_refresh_tokens' )->where( 'access_token_id' , $accessToken->id )->delete();
            return response()->json( Responser::success( trans( 'messages.logout' ) ) , 200 );
        }

    }

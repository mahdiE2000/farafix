<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Requests\Auth\LoginRequest;
    use App\Http\Resources\UserResource;
    use App\Models\User;
    use App\Services\Notification\SmsNotification;
    use App\Services\Responser;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Cache;

    class LoginHandler extends Controller
    {
        const cacheName = 'login_user_cell_number_';

        public function __invoke( Request $request ): JsonResponse
        {
            $credentials = $this->findCredentials( $request );
            if ( auth()->attempt( $credentials ) ) {
                if ( auth()->user()->isVerified() ) {
                    $token = auth()->user()->createToken( 'Personal Client' )->accessToken;
                    return response()->json( Responser::data(
                        [ 'token' => $token , 'user' => new UserResource( auth()->user() ) ]
                    ) , 200 );
                }
                return response()->json( Responser::error( [ 'verification' => trans( 'messages.not_verified' ) ] ) , 422 );
            }
            return response()->json( Responser::error( [ 'credentials' => trans( 'messages.credentials' ) ] ) , 422 );
        }

        public function sendCode( Request $request ): JsonResponse
        {
            $request->validate( [
                'cell_number' => 'required|string|regex:/^09[0-9]{9}$/'
            ] );

            $userCollection = User::query()->where( 'cell_number' , $request->cell_number );
            $user = $userCollection->first();
            if ( $user ) {
                $code = rand( 10000 , 99999 );
                Cache::put( self::cacheName . $user->cell_number , $code , 200 );

                SmsNotification::to( $userCollection )->isSystematic()->send( trans( 'sms.one_time_password' , [
                    'activation_code' => $code
                ] ) , 'service' );

                return response()->json( Responser::success( trans( 'messages.one_time_code' ) ) , 200 );
            } else {
                return response()->json( Responser::error( [ 'cell_number' => trans( 'messages.cell_number_not_exists' ) ] ) , 422 );
            }
        }

        public function verifyCode( Request $request ): JsonResponse
        {
            $request->validate( [
                'cell_number' => 'required|string|regex:/^09[0-9]{9}$/' ,
                'code' => 'required'
            ] );

            if ( $user = $this->checkLoginCode( $request->cell_number , $request->code ) ) {
                auth()->loginUsingId( $user->id );
                $this->changeUserVerified( $user );
                $token = auth()->user()->createToken( 'Personal Client' )->accessToken;
                return response()->json( Responser::data(
                    [ 'token' => $token , 'user' => new UserResource( auth()->user() ) ]
                ) , 200 );
            } else {
                return response()->json( Responser::error( [ 'cell_number' => trans( 'messages.invalid_code' ) ] ) , 422 );
            }
        }

        private function checkLoginCode( $cell_number , $code )
        {
            if ( Cache::has( self::cacheName . $cell_number ) and Cache::get( self::cacheName . $cell_number ) == $code ) {
                return User::query()->where( 'cell_number' , $cell_number )->first();
            }
            return null;
        }

        private function findCredentials( Request $request ): array
        {
            $request = resolve( LoginRequest::class );
            return
                [
                    "cell_number" => $request->cell_number ,
                    'password' => $request->password
                ];
        }

        private function changeUserVerified( $user )
        {
            $user->verified = true;
            $user->save();
        }
    }

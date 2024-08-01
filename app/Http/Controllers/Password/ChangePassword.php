<?php

    namespace App\Http\Controllers\Password;

    use App\Services\Responser;
    use Illuminate\Http\JsonResponse;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Hash;

    class ChangePassword extends Controller
    {
        public function __invoke(): JsonResponse
        {
            $passwordRequestData = request()->validate( [
                'current_password' => 'required|string' ,
                'password' => 'required|confirmed|string|min:8'
            ] );

            if ( Hash::check( $passwordRequestData[ 'current_password' ] , auth()->user()->password ) ) {
                $user = auth()->user();
                $user->password = bcrypt( $passwordRequestData[ 'password' ] );
                $user->save();

                return response()->json( Responser::success() );
            } else {
                return response()->json( Responser::error( [ 'credentials' => trans( 'messages.incorrect_current_password' ) ] ) , 422 );
            }
        }
    }

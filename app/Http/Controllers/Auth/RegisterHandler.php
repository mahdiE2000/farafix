<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Auth\RegisterRequest;
    use App\Models\User;
    use App\Services\Responser;
    use App\Services\UserVerifier;

    class RegisterHandler extends Controller
    {
        public function __invoke( RegisterRequest $request ): array
        {
            $userOld = User::where( "cell_number" , $request->cell_number )->where( 'verified' , 0 )->first();
            if ( $userOld ) {
                $userOld->forceDelete();
            }
            $data = [];
            $data[ 'name' ] = $request[ 'name' ];
            $data[ 'password' ] = bcrypt( $request->password );
            $data[ 'cell_number' ] = $request->cell_number;
            $user = User::query()->create( $data );
            UserVerifier::sendCode( $user );

            return Responser::success( trans( 'messages.verify_code_sent' ) );
        }
    }

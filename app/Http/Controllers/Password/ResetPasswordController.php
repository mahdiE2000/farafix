<?php

    namespace App\Http\Controllers\Password;

    use App\Http\Resources\UserResource;
    use App\Models\ResetPassword;
    use App\Models\User;
    use App\Services\Notification\SmsNotification;
    use App\Services\Responser;
    use Carbon\Carbon;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;

    class ResetPasswordController extends Controller
    {

        public function __invoke( Request $request ): array
        {
            $request->validate( [
                'password' => 'required|string|confirmed' ,
            ] );
            auth( 'api' )->user()->password = bcrypt( $request->password );
            auth( 'api' )->user()->verified = true;
            auth( 'api' )->user()->save();
            return Responser::success( trans( 'messages.password_changed' ) );
        }

        public function forgot( Request $request )
        {
            $request->validate( [
                'cell_number' => 'required|string|regex:/^09[0-9]{9}$/' ,
            ] );
            $userCollect = User::where( 'cell_number' , $request->cell_number );
            $user = $userCollect->first();

            if ( ! $user ) {
                return response()->json( Responser::error( [ 'cell_number' => trans( 'messages.cell_number_not_exists' ) ] ) , 422 );
            }

            $resetPassword = ResetPassword::updateOrCreate(
                [ 'cell_number' => $user->cell_number ] ,
                [
                    'cell_number' => $user->cell_number ,
                    'code' => rand( 100000 , 999999 )
                ]
            );

            if ( $resetPassword ) {
                SmsNotification::to( $userCollect )->isSystematic()->send(
                    trans( 'sms.register_confirm' , [
                        'activation_code' => $resetPassword->code
                    ] ) ,
                    'service'
                );
                return response()->json( Responser::success( trans( 'messages.remember_code_sent' ) ) );
            }
        }

        public function verify( Request $request ): JsonResponse
        {
            $resetPassword = ResetPassword::where( 'code' , $request->code )->where( 'cell_number' , $request->cell_number )->first();

            if ( ! $resetPassword ) {
                return response()->json( Responser::error( [ 'cell_number' => trans( 'messages.invalid_code' ) ] ) , 422 );
            }

            if ( Carbon::parse( $resetPassword->updated_at )->addMinutes( 360 )->isPast() ) {
                $resetPassword->delete();
                return response()->json( Responser::success( trans( 'messages.invalid_code' ) ) , 404 );
            }
            $user = User::where( 'cell_number' , $resetPassword->cell_number )->firstOrFail();
            $resetPassword->delete();

            $token = $user->createToken( 'Personal Client' )->accessToken;

            return response()->json( Responser::data(
                [ 'token' => $token , 'user' => new UserResource( $user ) ]
            ) , 200 );
        }

    }

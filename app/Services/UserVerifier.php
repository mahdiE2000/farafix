<?php

    namespace App\Services;

    use App\Models\User;
    use App\Services\Notification\SmsNotification;
    use Illuminate\Support\Facades\Cache;

    class UserVerifier
    {

        public static function sendCode( $user ): void
        {
            $randNumber = rand( 100000 , 999999 );
            Cache::put( 'phone_number_' . $randNumber , $user->id , 120 );
            $user = User::where( 'id' , $user->id );
            SmsNotification::to( $user )->isSystematic()->send(
                trans( 'sms.register_confirm' , [
                    'activation_code' => $randNumber
                ] ) ,
                'service'
            );
        }

        public static function verifyUser( $code )
        {
            $userId = Cache::pull( 'phone_number_' . $code );
            if ( $userId ) {
                $user = User::findOrFail( $userId );
                $user->verified = true;
                $user->save();
                return $user;
            }
        }

    }

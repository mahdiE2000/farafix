<?php

    namespace App\Http\Controllers\Sms;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Sms\SendSmsRequest;
    use App\Models\User;
    use App\Services\Notification\SmsNotification;
    use App\Services\Responser;
    use Illuminate\Http\JsonResponse;

    class SendSms extends Controller
    {
        public function __invoke( SendSmsRequest $request ): JsonResponse
        {
            $clients = User::whereNotNull( 'cell_number' )->where( 'id' , $request->id );
            SmsNotification::to( $clients )->send( $request->input( 'content' ) , "advertise" );

            return response()->json( Responser::success( trans( 'messages.sms_sent' ) ) );
        }
    }

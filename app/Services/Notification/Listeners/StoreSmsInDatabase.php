<?php

    namespace App\Services\Notification\Listeners;

    use App\Models\Sms;
    use App\Models\SmsBatch;
    use App\Services\Notification\Events\SmsSent;
    use Illuminate\Support\Facades\Log;

    class StoreSmsInDatabase
    {
        public function __construct()
        {}

        public function handle( SmsSent $event ): void
        {
            $chars_in_every_sms_part = config( "sms.sms_length_calculator.chars_in_every_sms_part" ) > 0 ? : 60;
            $smsList = [];

            foreach ( $event->collection as $key => $value ) {
                $smsList[ $key ] = new Sms( [
                    'client_id' => $event->response[ $key ][ 'ClientID' ] ,
                    'status' => $event->response[ $key ][ 'Status' ] ,
                    'message' => $event->payload[ $key ][ 'Message' ] ,
                    'rel_id' => $value->id ,
                    'segment_count' => ceil( strlen( $event->extra[ 'messagePattern' ] ) / $chars_in_every_sms_part ) ,
                    'cell_number' => $event->payload[ $key ][ 'Cellphone' ] ,
                    'rel_type' => $event->extra[ 'className' ] ,
                    'fee' => $event->extra[ 'fee' ] ,
                ] );
            }

            Log::alert( 'store SmsBatch' , [ 'hasSms' => SmsBatch::where( 'code' , $event->extra[ 'code' ] )->first()  ] );

            $smsBatch = SmsBatch::firstOrCreate(
                [
                    'code' => $event->extra[ 'code' ]
                ] ,
                [
                    'category' => $event->extra[ 'category' ] ,
                    'operator' => $event->extra[ 'operator' ] ,
                    'type' => $event->extra[ 'type' ] ,
                    'pattern' => $event->extra[ 'messagePattern' ] ,
                    'is_admin' => $event->extra[ 'is_admin' ] ,
                    'is_systematic' => $event->extra[ 'is_systematic' ] ,
                    'from' => $event->extra[ 'from' ] ,
                ]
            );

            $smsBatch->smsList()->saveMany( $smsList );
        }
    }

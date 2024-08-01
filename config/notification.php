<?php

use App\Models\Sms;

return [

    'db_name' => 'willaengine',

    'morph_models' => [],

    /*
    |--------------------------------------------------------------------------
    | Default Driver
    |--------------------------------------------------------------------------
    |
    | This value determines which of drivers should be used.
    |
    */
    'default' => 'advertise',

    /*
    |--------------------------------------------------------------------------
    | Notification Configs
    |--------------------------------------------------------------------------
    |
    | These are the list of configs to use for sending sms.
    |
    */

    'drivers' => [
        'advertise' => [
            'url' => 'http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl',
            'username' => env('SMS_USERNAME'),
            'password' => env('SMS_PASSWORD'),
            'from' => env('SMS_NUMBER_ADVERTISE'),
        ],
        'service' => [
            'url' => 'http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl',
            'username' => env('SMS_USERNAME'),
            'password' => env('SMS_PASSWORD'),
            'from' => env('SMS_NUMBER_SERVICE'),
        ],
        'simcard' => [
            'url' => 'http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl',
            'username' => env('SMS_USERNAME'),
            'password' => env('SMS_PASSWORD'),
            'from' => env('SMS_NUMBER_SIM_CARD'),
            'fee'  => 150
        ],
        'pattern' => [
            'url' => 'http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl',
            'username' => env('SMS_USERNAME'),
            'password' => env('SMS_PASSWORD'),
            'from' => env('SMS_NUMBER_SERVICE'),
        ],
        'rahyab_advertise' => [
            'url' => 'https://sms.igama.ir/webservice/sms.asmx?wsdl',
            'username' => env('RAHYAB_SMS_USERNAME'),
            'password' => env('RAHYAB_SMS_PASSWORD'),
            'from' => env('RAHYAB_SMS_NUMBER_ADVERTISE'),
            'fee'  => 100
        ],
        'rahyab_service' => [
            'url' => 'https://sms.igama.ir/webservice/sms.asmx?wsdl',
            'username' => env('RAHYAB_SMS_USERNAME'),
            'password' => env('RAHYAB_SMS_PASSWORD'),
            'from' => env('RAHYAB_SMS_NUMBER_SERVICE'),
            'fee'  => 80
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Class Maps
    |--------------------------------------------------------------------------
    |
    | This is the array of Classes that maps to Drivers above.
    |
    */
    'map' => [
        'advertise' => Sms::class,
        'service' => Sms::class,
        'simcard' => Sms::class,
        'pattern' => SmsPattern::class,
        'rahyab_advertise' => HelloWorld::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Fields Pattern
    |--------------------------------------------------------------------------
    |
    | This is the array of fields that used in sms patterns.
    |
    */

    'fields' => [
        'time' => now('Asia/Tehran')->format('H:i:s'),
        'date' => now('Asia/Tehran')->format('Y/m/d')
    ],

    /*
    |--------------------------------------------------------------------------
    | MAXIMUM NUMBER OF PHONE NUMBERS IN ONE BATCH
    |--------------------------------------------------------------------------
    |
    | CAUTION!! DONT TOUCH THESE NUMBERS
    |
    */

    'max_phone_size' => [
        'do_send_sms' => 83,
        'do_send_sms_array_c' => 100,
    ],
    'max_update_devlivery_status_bulk_items' => 100,
    'sms_length_calculator' => [
        'encoding' => '8', //bit
        'chars_in_every_sms_part' => 63
    ],


    'config_system' => [],

];

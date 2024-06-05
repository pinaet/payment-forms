<?php

return [

    'mode'      =>  env('APP_MODE', 'ticket-dev'),

    'start_year' => 1998,

    'event_email'           => 'events@iohconnect.com',
    'event_email_pass'      => 'Boq22841',
    'membership_email'      => 'membership@iohconnect.com',
    'membership_email_pass' => 'Xay51184',

    'ticket' => [
        'event_bcc'         => 'events@iohconnect.com',
        'membership_bcc'    => 'membership@iohconnect.com',
        'gate'              => [
            'order'         => env('GATE_ORDER_URL', 'https://applications.harrowschool.ac.th/gate/public/order')
        ]
    ],

    'ticket-dev' => [
        'event_bcc'         => 'pinaet@gmail.com,pinaet@hotmail.com',
        'membership_bcc'    => 'pinaet@gmail.com,pinaet@hotmail.com',
        'gate'              => [
            'order'         => env('GATE_ORDER_URL', 'https://histest.harrowschool.ac.th/gate/public/order')
        ]
    ],

    'application-fee' => [
        'bangkok' => [
            'openapply_api_url' => 'https://harrowbangkok.openapply.com/api/v1/students',
            'opa_auth_token'    => '036c9b40b10836fb783b70637ad9c921',
        ],
    ],

];

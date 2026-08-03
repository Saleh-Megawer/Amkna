<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    */
    'auth'  => [
        'register' => [
            'name_required'         => 'Enter your name.',
            'name_invalid'          => 'Enter a valid name.',
            'email_invalid'         => 'Enter a valid email address.',
            'password_required'     => 'Enter your password.',
            'password_rules'        => 'Use a strong password (8+ chars, upper/lowercase, and a number).',
            'country_code_required' => 'Select a country code.',
            'country_code_invalid'  => 'Invalid country code.',
            'phone_required'        => 'Enter your phone number.',
            //
            'email_exists'          => 'This account is already registered. Please sign in.',
            'phone_exists'          => 'This phone number is already in use.',
        ],
        //
        'login'    => [
            'login_required'      => 'Enter your phone or email.',
            'password_required'   => 'Enter your password.',
            'login_invalid'       => 'Enter a valid phone number or email.',
            'invalid_credentials' => 'Incorrect phone/email or password.',
            'banned'              => 'Your account is blocked.',
            'throttle'            => 'Too many attempts. Try again in :seconds seconds.',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Phone
    |--------------------------------------------------------------------------
    */
    'phone' => [
        'config_missing' => 'Phone number length configuration is missing.',
        'required'       => 'Phone number is required.',
        'local_only'     => 'Please enter the local number only without + or 00',
        'length'         => 'Phone number must be :expected digits based on the selected country code.',
        'invalid_cc'     => 'Invalid country code.',
    ],

];

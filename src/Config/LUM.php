<?php

return [
    /* Important Settings */
    'backend_lum_middlewares'     => explode(',', env('LUM_BACKEND_MIDDLEWARES', 'web')),
    'frontend_lum_middlewares'    => explode(',', env('LUM_FRONTEND_MIDDLEWARES', 'web')),
    'backend_lum_route_prefix'    => env('LUM_BACKEND_ROUTE_PERFIX', 'LUM'),
    'frontend_lum_route_prefix'   => env('LUM_FRONTEND_ROUTE_PERFIX', 'LUM'),
    'user_model'                  => env('LUM_USER_MODEL', 'ArtinCMS\LUM\Models\UserManagement'),
    'user_table'                  => env('LUM_USER_TABLE', 'lum_users'),
    'mobile_confirmed_field'      => env('LUM_MOBILE_CONFIRMED_MOBILE_FIELD', 'mobile_confirmed'),
    'email_confirmed_field'      => env('LUM_EMAIL_CONFIRMED_MOBILE_FIELD', 'email_confirmed'),
    'user_confirmed_field'        => env('LUM_USER_CONFIRMED_FIELD', 'user_confirmed'),

    //-----------------FOR EXTERNAL USER CONTROLLER
    'have_external_controller'    => env('LUM_HAVE_EXTERNAL_CONTROLLER', false),
    'user_controller_name'        => env('LUM_USER_CONTROLLER_NAME', 'UserManagementController'),
    'user_controller_name_space'  => env('LUM_USER_CONTROLLER_NAME_SPACE', 'ArtinCMS\LUM\Controllers'),

    //------------------Auth Config
    'register_model'              => env('LUM_REGISTER_DATA', 'ArtinCMS\LUM\Controllers'),
    'accept_term_url'             => env('LUM_ACCEPT_TERM_URL', '#'),
    'the_email_must_be_checked'   => env('LUM_THE_EMAIL_MUST_BE_CHECKED', true),
    'expire_date'                 => env('LUM_EXPIRE_DATE', 3000),
    'url_after_login'             => env('LUM_URL_AFTER_LOGIN', 'http://127.0.0.1:8000'),
    'url_after_recovery_password' => env('LUM_URL_AFTER_RECOVERY_PASSWROD', 'http://127.0.0.1:8000'),

    'activation_url_redirect_func_name' => env('LUM_ACTIVATION_URL_REDIRECT_FUNC_NAME', 'LUM_activation_url'),
];
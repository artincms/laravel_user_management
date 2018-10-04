<?php

return [
    /* Important Settings */
    'backend_lum_middlewares'    => explode(',', env('LUM_BACKEND_MIDDLEWARES', 'web')),
    'frontend_lum_middlewares'   => explode(',', env('LUM_FRONTEND_MIDDLEWARES', 'web')),
    'backend_lum_route_prefix'   => env('LUM_BACKEND_ROUTE_PERFIX', 'LUM'),
    'frontend_lum_route_prefix'  => env('LUM_FRONTEND_ROUTE_PERFIX', 'LUM'),
    'user_model'                 => env('LUM_USER_MODEL', 'ArtinCMS\LUM\Models\UserManagement'),

    //-----------------FOR EXTERNAL USER CONTROLLER
    'have_external_controller'   => env('LUM_HAVE_EXTERNAL_CONTROLLER', false),
    'user_controller_name'       => env('LUM_USER_CONTROLLER_NAME', 'UserManagementController'),
    'user_controller_name_space' => env('LUM_USER_CONTROLLER_NAME_SPACE', 'ArtinCMS\LUM\Controllers'),

    //------------------Auth Config
    'register_model'             => env('LUM_REGISTER_DATA', 'ArtinCMS\LUM\Controllers'),
    'accept_term_url'            => env('LUM_ACCEPT_TERM_URL', '#'),
    'the_email_must_be_checked'  => env('LUM_THE_EMAIL_MUST_BE_CHECKED', true),
    'expire_date'                => env('LUM_EXPIRE_DATE', 300),

    'activation_url_redirect_func_name' => env('LUM_ACTIVATION_URL_REDIRECT_FUNC_NAME', 'LUM_activation_url'),
];
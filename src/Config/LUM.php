<?php

return [
    /* Important Settings */
    'backend_lum_middlewares'             => env('BACKEND_LUM_MIDDLEWARES', 'web'),
    'frontend_lum_middlewares'            => env('FRONTEND_LUM_MIDDLEWARES', 'web'),
    'backend_lum_route_prefix'            => env('BACKEND_LUM_ROUTE_PERFIX', 'LUM'),
    'frontend_lum_route_prefix'           => env('FRONTEND_LUM_ROUTE_PERFIX', 'LUM'),
    'user_model'                          => env('LUM_USER_MODEL', 'ArtinCMS\LUM\Models\UserManagement'),

    //-----------------FOR EXTERNAL USER CONTROLLER
    'have_external_controller'            => env('HAVE_EXTERNAL_CONTROLLER', false),
    'user_controller_name'                => env('USER_CONTROLLER_NAME', 'UserManagement'),
    'external_user_controller_name_space' => env('EXTERNAL_USER_CONTROLLER_NAME_SPACE', 'ArtinCMS\LUM\Controllers'),

    //------------------Auth Config
    'register_model'                      => env('LUM_REGISTER_DATA', 'ArtinCMS\LUM\Controllers'),
    'accept_term_url'                     => env('ACCEPT_TERM_URL', '#'),
    'the_email_must_be_checked'           => env('THE_EMAIL_MUST_BE_CHECKED', true),
    'expire_date'                         => env('EXPIRE_DATE', 300),

    'activation_url_redirect_func_name' => env('ACTIVATION_URL_REDIRECT_FUNC_NAME', 'LUM_activationUrl'),


];
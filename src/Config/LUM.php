<?php

return [
    /* Important Settings */
    'backend_lum_middlewares' => env('BACKEND_LUM_MIDDLEWARES', 'web'),
    'frontend_lum_middlewares' => env('FRONTEND_LUM_MIDDLEWARES', 'web'),
    // you can change default route from sms-admin to anything you want
    'backend_lum_route_prefix' =>  env('BACKEND_LUM_ROUTE_PERFIX', 'LUM'),
    'frontend_lum_route_prefix' => env('FRONTEND_LUM_ROUTE_PERFIX', 'LUM'),
    'user_model'=>env('LUM_USER_MODEL', 'App\User'),

    //-----------------FOR EXTERNAL USER CONTROLLER
    'have_external_controller' => env('HAVE_EXTERNAL_CONTROLLER', true),
    'user_controller_name' => env('USER_CONTROLLER_NAME', 'UserManagement'),
    'external_user_controller_name_space' => env('EXTERNAL_USER_CONTROLLER_NAME_SPACE', 'ArtinCMS\LUM\Controllers'),
];
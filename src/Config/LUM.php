<?php

return [
    /* Important Settings */
    'backend_lum_middlewares' => env('BACKEND_LUM_MIDDLEWARES', 'web'),
    'frontend_lum_middlewares' => env('FRONTEND_LUM_MIDDLEWARES', 'web'),
    // you can change default route from sms-admin to anything you want
    'backend_lum_route_prefix' =>  env('BACKEND_LUM_ROUTE_PERFIX', 'LUM'),
    'frontend_lum_route_prefix' => env('FRONTEND_LUM_ROUTE_PERFIX', 'LUM'),
    // ======================================================================
    //allow user to upload private file in filemanager
    'user_model'=>env('LUM_USER_MODEL', 'App\User'),
];
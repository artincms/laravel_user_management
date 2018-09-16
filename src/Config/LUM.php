<?php

return [

    /* Important Settings */
    'backend_lum_middlewares' => ['web'],
    'frontend_lum_middlewares' => ['web'],
    // you can change default route from sms-admin to anything you want
    'backend_lum_route_prefix' => 'LUM',
    'frontend_lum_route_prefix' => 'LUM',
    // ======================================================================
    //allow user to upload private file in filemanager
    'userModel'=>'App\User',
];
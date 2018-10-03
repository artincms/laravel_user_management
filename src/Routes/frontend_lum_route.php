<?php
Route::group(['prefix' => config('laravel_user_management.frontend_lum_route_prefix'), 'namespace' => 'ArtinCMS\LUM\Controllers', 'middleware' => config('laravel_user_management.frontend_lum_middlewares')], function () {

    //login form
    Route::group(['prefix' => 'Login'], function () {
        Route::get('index', ['as' => 'LUM.Login.index', 'uses' => 'LoginController@index']);
        Route::post('addLogin', ['as' => 'LUM.Login.addLogin', 'uses' => 'LoginController@addLogin']);

    });

    Route::group(['prefix' => 'Password'], function () {
        Route::Post('email', ['as' => 'LUM.Password.email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
        Route::get('reset', ['as' => 'LUM.Password.request', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
        Route::Post('reset', ['as' => 'LUM.Password.update', 'uses' => 'ResetPasswordController@reset']);
        Route::get('reset/{token}', ['as' => 'LUM.Password.reset', 'uses' => 'ResetPasswordController@howResetForm']);
    });

    Route::get('register', ['as' => 'LUM.register', 'uses' => 'RegisterController@index']);
    Route::post('register', ['as' => 'LUM.register', 'uses' => 'RegisterController@register']);
    Route::post('addRegister', ['as' => 'LUM.register.addRegister', 'uses' => 'RegisterController@addRegister']);

    Route::group(['prefix' => 'Activation'], function () {
        Route::get('active/{code}', ['as' => 'LUM.Activation.activationUser', 'uses' => 'RegisterController@activationUser']);
        Route::get('failed', ['as' => 'LUM.Activation.failedActivation', 'uses' => 'RegisterController@failedActivation']);
        Route::get('expired', ['as' => 'LUM.Activation.expiredActivation', 'uses' => 'RegisterController@expiredActivation']);
        Route::get('successed', ['as' => 'LUM.Activation.successedActivation', 'uses' => 'RegisterController@successedActivation']);
    });
});
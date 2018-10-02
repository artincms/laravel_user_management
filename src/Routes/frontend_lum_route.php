<?php
Route::group(['prefix' => config('laravel_user_management.frontend_lum_route_prefix'), 'namespace' => 'ArtinCMS\LUM\Controllers', 'middleware' => config('laravel_user_management.frontend_lum_middlewares')], function () {

    //login form
    Route::get('login', ['as' => 'LUM.login', 'uses' => 'LoginController@showLoginForm']);
    Route::Post('login', ['as' => 'LUM.saveLogin', 'uses' => 'LoginController@login']);
    Route::Post('logout', ['as' => 'LUM.logout', 'uses' => 'LoginController@logout']);

    Route::group(['prefix' => 'Password'], function () {
        Route::Post('email', ['as' => 'LUM.Password.email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
        Route::get('reset', ['as' => 'LUM.Password.request', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
        Route::Post('reset', ['as' => 'LUM.Password.update', 'uses' => 'ResetPasswordController@reset']);
        Route::get('reset/{token}', ['as' => 'LUM.Password.reset', 'uses' => 'ResetPasswordController@howResetForm']);
    });

    Route::get('register', ['as' => 'LUM.register', 'uses' => 'RegisterController@index']);
    Route::post('register', ['as' => 'LUM.register', 'uses' => 'RegisterController@register']);
    Route::post('addRegister', ['as' => 'LUM.register.addRegister', 'uses' => 'RegisterController@addRegister']);
});
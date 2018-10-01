<?php
Route::group(['prefix' => config('laravel_user_management.backend_lum_route_prefix'), 'namespace' =>  config('laravel_user_management.external_user_controller_name_space'), 'middleware' => config('laravel_user_management.backend_lum_middlewares')], function () {
    Route::group(['prefix' => 'Users'], function () {
        Route::get('manage', ['as' => 'LUM.Users.manage', 'uses' => config('laravel_user_management.user_controller_name').'@index']);
        Route::post('getUsers', ['as' => 'LUM.Users.getUsers', 'uses' => config('laravel_user_management.user_controller_name').'@getUsers']);
        Route::post('getEditUserForm', ['as' => 'LUM.Users.getEditUserForm', 'uses' => config('laravel_user_management.user_controller_name').'@getEditUserForm']);
        Route::post('setUserStatus', ['as' => 'LUM.Users.setUserStatus', 'uses' => config('laravel_user_management.user_controller_name').'@setUserStatus']);
        Route::post('setEmailStatus', ['as' => 'LUM.Users.setEmailStatus', 'uses' => config('laravel_user_management.user_controller_name').'@setEmailStatus']);
        Route::post('trashUser', ['as' => 'LUM.Users.trashUser', 'uses' => config('laravel_user_management.user_controller_name').'@trashUser']);
        Route::post('addUsers', ['as' => 'LUM.Users.addUsers', 'uses' => config('laravel_user_management.user_controller_name').'@addUsers']);
        Route::post('editUser', ['as' => 'LUM.Users.editUser', 'uses' => config('laravel_user_management.user_controller_name').'@editUser']);
    });
});
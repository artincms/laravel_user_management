<?php
Route::group(['prefix' => config('laravel_user_management.backend_lum_route_prefix'), 'namespace' => 'ArtinCMS\LUM\Controllers', 'middleware' => config('laravel_user_management.backend_lum_middlewares')], function () {
    Route::group(['prefix' => 'Users'], function () {
        Route::get('manage', ['as' => 'LUM.Users.manage', 'uses' => 'UserManagementController@index']);
        Route::post('getUsers', ['as' => 'LUM.Users.getUsers', 'uses' => 'UserManagementController@getUsers']);
        Route::post('getEditUserForm', ['as' => 'LUM.Users.getEditUserForm', 'uses' => 'UserManagementController@getEditUserForm']);
        Route::post('setUserStatus', ['as' => 'LUM.Users.setUserStatus', 'uses' => 'UserManagementController@setUserStatus']);
        Route::post('setEmailStatus', ['as' => 'LUM.Users.setEmailStatus', 'uses' => 'UserManagementController@setEmailStatus']);
        Route::post('trashUser', ['as' => 'LUM.Users.trashUser', 'uses' => 'UserManagementController@trashUser']);
    });

    Route::group(['prefix' => 'Users'], function () {
        Route::post('getRoles', ['as' => 'LUM.Roles.getRoles', 'uses' => 'UserManagementController@getRoles']);
    });
});
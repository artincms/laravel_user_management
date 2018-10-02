<?php
Route::group(['prefix' => config('laravel_user_management.backend_lum_route_prefix'), 'namespace' =>  'ArtinCMS\LUM\Controllers', 'middleware' => config('laravel_user_management.backend_lum_middlewares')], function () {
    Route::group(['prefix' => 'Users'], function () {
        Route::get('index', ['as' => 'LUM.Users.index', 'uses' => 'UserManagementController@index']);
        Route::post('getUsers', ['as' => 'LUM.Users.getUsers', 'uses' => 'UserManagementController@getUsers']);
        Route::post('getEditUserForm', ['as' => 'LUM.Users.getEditUserForm', 'uses' => 'UserManagementController@getEditUserForm']);
        Route::post('setUserStatus', ['as' => 'LUM.Users.setUserStatus', 'uses' => 'UserManagementController@setUserStatus']);
        Route::post('setEmailStatus', ['as' => 'LUM.Users.setEmailStatus', 'uses' => 'UserManagementController@setEmailStatus']);
        Route::post('setMobileStatus', ['as' => 'LUM.Users.setMobileStatus', 'uses' => 'UserManagementController@setMobileStatus']);
        Route::post('trashUser', ['as' => 'LUM.Users.trashUser', 'uses' => 'UserManagementController@trashUser']);
        Route::post('addUsers', ['as' => 'LUM.Users.addUsers', 'uses' => 'UserManagementController@addUsers']);
        Route::post('editUser', ['as' => 'LUM.Users.editUser', 'uses' => 'UserManagementController@editUser']);
    });
});
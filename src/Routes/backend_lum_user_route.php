<?php
Route::group(['prefix' => config('laravel_user_management.backend_lum_route_prefix'), 'namespace' =>  'ArtinCMS\LUM\Controllers', 'middleware' => config('laravel_user_management.backend_lum_middlewares')], function () {
    Route::group(['prefix' => 'Users'], function () {
        Route::get('manage', ['as' => 'LUM.Users.manage', 'uses' => 'LUM_UserManagementController@index']);
        Route::post('getUsers', ['as' => 'LUM.Users.getUsers', 'uses' => 'LUM_UserManagementController@getUsers']);
        Route::post('getEditUserForm', ['as' => 'LUM.Users.getEditUserForm', 'uses' => 'LUM_UserManagementController@getEditUserForm']);
        Route::post('setUserStatus', ['as' => 'LUM.Users.setUserStatus', 'uses' => 'LUM_UserManagementController@setUserStatus']);
        Route::post('setEmailStatus', ['as' => 'LUM.Users.setEmailStatus', 'uses' => 'LUM_UserManagementController@setEmailStatus']);
        Route::post('trashUser', ['as' => 'LUM.Users.trashUser', 'uses' => 'LUM_UserManagementController@trashUser']);
        Route::post('addUsers', ['as' => 'LUM.Users.addUsers', 'uses' => 'LUM_UserManagementController@addUsers']);
        Route::post('editUser', ['as' => 'LUM.Users.editUser', 'uses' => 'LUM_UserManagementController@editUser']);
    });
});
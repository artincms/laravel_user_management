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

    Route::group(['prefix' => 'Roles'], function () {
        Route::post('getRoles', ['as' => 'LUM.Roles.getRoles', 'uses' => 'UserManagementController@getRoles']);
        Route::post('addRoles', ['as' => 'LUM.Roles.addRoles', 'uses' => 'UserManagementController@addRoles']);
        Route::post('changeRoleStauts', ['as' => 'LUM.Roles.changeRoleStauts', 'uses' => 'UserManagementController@changeRoleStauts']);
        Route::post('getEditRolesForm', ['as' => 'LUM.Roles.getEditRolesForm', 'uses' => 'UserManagementController@getEditRolesForm']);
        Route::post('editRoles', ['as' => 'LUM.Roles.editRoles', 'uses' => 'UserManagementController@editRoles']);
        Route::post('trashRoles', ['as' => 'LUM.Roles.trashRoles', 'uses' => 'UserManagementController@trashRoles']);
    });
    Route::group(['prefix' => 'Permissions'], function () {
        //permission category
        Route::post('getPermissionCategorys', ['as' => 'LUM.Permissions.getPermissionCategorys', 'uses' => 'PermissionManagementController@getPermissionCategorys']);
        Route::post('addPermissionCategorys', ['as' => 'LUM.Permissions.addPermissionCategorys', 'uses' => 'PermissionManagementController@addPermissionCategorys']);
        Route::post('changePermissionCategoryStauts', ['as' => 'LUM.Permissions.changePermissionCategoryStauts', 'uses' => 'PermissionManagementController@changePermissionCategoryStauts']);
        Route::post('getEditPermissionCategorysForm', ['as' => 'LUM.Permissions.getEditPermissionCategorysForm', 'uses' => 'PermissionManagementController@getEditPermissionCategorysForm']);
        Route::post('editPermissionCategorys', ['as' => 'LUM.Permissions.editPermissionCategorys', 'uses' => 'PermissionManagementController@editPermissionCategorys']);
        Route::post('trashPermissionCategorys', ['as' => 'LUM.Permissions.trashPermissionCategorys', 'uses' => 'PermissionManagementController@trashPermissionCategorys']);
        Route::post('autoCompletePermissionCategory', ['as' => 'LUM.Permissions.autoCompletePermissionCategory', 'uses' => 'PermissionManagementController@autoCompletePermissionCategory']);

        //permission
        Route::post('getPermissions', ['as' => 'LUM.Permissions.getPermissions', 'uses' => 'PermissionManagementController@getPermissions']);
        Route::post('addPermissions', ['as' => 'LUM.Permissions.addPermissions', 'uses' => 'PermissionManagementController@addPermissions']);
        Route::post('changePermissionStauts', ['as' => 'LUM.Permissions.changePermissionStauts', 'uses' => 'PermissionManagementController@changePermissionStauts']);
        Route::post('getEditPermissionsForm', ['as' => 'LUM.Permissions.getEditPermissionsForm', 'uses' => 'PermissionManagementController@getEditPermissionsForm']);
        Route::post('editPermissions', ['as' => 'LUM.Permissions.editPermissions', 'uses' => 'PermissionManagementController@editPermissions']);
        Route::post('trashPermissions', ['as' => 'LUM.Permissions.trashPermissions', 'uses' => 'PermissionManagementController@trashPermissions']);
        Route::post('addRoleToPermission', ['as' => 'LUM.Permissions.addRoleToPermission', 'uses' => 'PermissionManagementController@addRoleToPermission']);
        Route::post('getRolePermissionForm', ['as' => 'LUM.Permissions.getRolePermissionForm', 'uses' => 'PermissionManagementController@getRolePermissionForm']);
    });
});
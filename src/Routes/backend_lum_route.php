<?php
Route::group(['prefix' => config('laravel_user_management.backend_lum_route_prefix'), 'namespace' => 'ArtinCMS\LUM\Controllers', 'middleware' => config('laravel_user_management.backend_lum_middlewares')], function () {
      Route::group(['prefix' => 'Roles'], function () {
        Route::post('getRoles', ['as' => 'LUM.Roles.getRoles', 'uses' => 'RoleManagementController@getRoles']);
        Route::post('addRoles', ['as' => 'LUM.Roles.addRoles', 'uses' => 'RoleManagementController@addRoles']);
        Route::post('changeRoleStauts', ['as' => 'LUM.Roles.changeRoleStauts', 'uses' => 'RoleManagementController@changeRoleStauts']);
        Route::post('getEditRolesForm', ['as' => 'LUM.Roles.getEditRolesForm', 'uses' => 'RoleManagementController@getEditRolesForm']);
        Route::post('editRoles', ['as' => 'LUM.Roles.editRoles', 'uses' => 'RoleManagementController@editRoles']);
        Route::post('trashRoles', ['as' => 'LUM.Roles.trashRoles', 'uses' => 'RoleManagementController@trashRoles']);
        Route::post('getUserRoleForm', ['as' => 'LUM.Roles.getUserRoleForm', 'uses' => 'RoleManagementController@getUserRoleForm']);
        Route::post('getUserTeamForm', ['as' => 'LUM.Roles.getUserTeamForm', 'uses' => 'RoleManagementController@getUserTeamForm']);
        Route::post('addRoleToUsers', ['as' => 'LUM.Roles.addRoleToUsers', 'uses' => 'RoleManagementController@addRoleToUsers']);
        Route::post('getLogs', ['as' => 'LUM.Roles.getLogs', 'uses' => 'RoleManagementController@getLogs']);
    });
    Route::group(['prefix' => 'Teams'], function () {
        Route::post('getTeams', ['as' => 'LUM.Teams.getTeams', 'uses' => 'RoleManagementController@getTeams']);
        Route::post('addTeams', ['as' => 'LUM.Teams.addTeams', 'uses' => 'RoleManagementController@addTeams']);
        Route::post('changeTeamStauts', ['as' => 'LUM.Teams.changeTeamStauts', 'uses' => 'RoleManagementController@changeTeamStauts']);
        Route::post('getEditTeamsForm', ['as' => 'LUM.Teams.getEditTeamsForm', 'uses' => 'RoleManagementController@getEditTeamsForm']);
        Route::post('editTeams', ['as' => 'LUM.Teams.editTeams', 'uses' => 'RoleManagementController@editTeams']);
        Route::post('trashTeams', ['as' => 'LUM.Teams.trashTeams', 'uses' => 'RoleManagementController@trashTeams']);
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
<?php
Route::group(['prefix' => config('laravel_user_management.backend_lum_route_prefix'), 'namespace' => 'ArtinCMS\LUM\Controllers', 'middleware' => config('laravel_user_management.backend_lum_middlewares')], function () {
    Route::get('manageUser', ['as' => 'LUM.manageUser', 'uses' => 'LumController@manageUser']);
});
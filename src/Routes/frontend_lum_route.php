<?php
Route::group(['prefix' => config('laravel_user_management.frontend_lum_route_prefix'), 'namespace' => 'ArtinCMS\LUM\Controllers', 'middleware' => config('laravel_user_management.frontend_lum_middlewares')], function () {

});
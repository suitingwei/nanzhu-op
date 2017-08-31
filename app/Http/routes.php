<?php

Route::get('/', 'HomeController@welcome');

Route::group(['middleware' => ['web','http_basic_auth']], function () {
    Route::auth();
});

require app_path('Http/admin_routes.php');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

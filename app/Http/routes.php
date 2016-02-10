<?php

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::group(['middleware' => 'auth'], function () {
        Route::controllers([
            'users' => "UsersController"
        ]);
        Route::get('users', [
            'as' => 'users', 'uses' => 'UsersController@getIndex'
        ]);
        Route::get('/', 'HomeController@index');
    });
});

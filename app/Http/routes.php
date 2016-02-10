<?php

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::group(['middleware' => 'auth'], function () {
        Route::controllers([
            'users' => "UsersController",
            'anticafes' => "AnticafeController",
            'image-options' => "ImageOptionsController"
        ]);
        Route::get('users', [
            'as' => 'users', 'uses' => 'UsersController@getIndex'
        ]);
        Route::get('anticafes', [
            'as' => 'anticafes', 'uses' => 'AnticafeController@getIndex'
        ]);
        Route::get('image-options', [
            'as' => 'ioptions', 'uses' => 'ImageOptionsController@getIndex'
        ]);
        Route::get('/', 'HomeController@index');
    });
});

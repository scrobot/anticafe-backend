<?php

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::group(['middleware' => 'auth'], function () {
        Route::controllers([
            'users' => "UsersController",
            'anticafes' => "AnticafeController",
            'image-options' => "ImageOptionsController",
            'events' => "EventsController",
            'tags' => "TagsController",
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
        Route::get('events', [
            'as' => 'events', 'uses' => 'EventsController@getIndex'
        ]);
        Route::get('tags', [
            'as' => 'tags', 'uses' => 'TagsController@getIndex'
        ]);
        Route::get('/', 'HomeController@index');
    });
});

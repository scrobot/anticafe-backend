<?php

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::group(['middleware' => 'auth'], function () {
        Route::controllers([
            'users' => "UsersController",
            'anticafes' => "AnticafeController",
            'events' => "EventsController",
            'image-options' => "ImageOptionsController",
            'tags' => "TagsController",
            'clients' => "ClientsController",
        ]);
        Route::get('users', [
            'as' => 'users', 'uses' => 'UsersController@getIndex'
        ]);
        Route::get('anticafes', [
            'as' => 'anticafes', 'uses' => 'AnticafeController@getIndex'
        ]);
        Route::get('events', [
            'as' => 'events', 'uses' => 'EventsController@getIndex'
        ]);
        Route::get('image-options', [
            'as' => 'ioptions', 'uses' => 'ImageOptionsController@getIndex'
        ]);
        Route::get('tags', [
            'as' => 'tags', 'uses' => 'TagsController@getIndex'
        ]);
        Route::get('clients', [
            'as' => 'clients', 'uses' => 'ClientsController@getIndex'
        ]);
        Route::get('bookings', [
            'as' => 'bookings', 'uses' => 'BookingsController@getIndex'
        ]);
        Route::post('bookings/change-statuses', [
            'as' => 'bookings.status', 'uses' => 'BookingsController@postChangeStatus'
        ]);
        Route::get('/', 'HomeController@index');
    });
});

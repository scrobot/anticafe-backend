<?php

Route::group(['prefix' => 'api', 'middleware' => 'app-api'], function() {
    Route::get('home', 'ApiController@getMain');
    Route::get('home/{count}', 'ApiController@getMain');
    Route::post('vk', 'ApiController@postVk');
    Route::post('fb', 'ApiController@postFb');
    Route::post('vk/update', 'ApiController@postAddVkProfileToUser');
    Route::post('fb/update', 'ApiController@postAddFbProfileToUser');
    Route::get('anticafes', 'ApiController@getAnticafes');
    Route::get('anticafes/{count}', 'ApiController@getAnticafes');
    Route::get('anticafes/{count}/{limit}', 'ApiController@getAnticafes');
    Route::get('events', 'ApiController@getEvents');
    Route::get('events/{count}', 'ApiController@getEvents');
    Route::get('events/{count}/{limit}', 'ApiController@getEvents');
    Route::get('tags', 'ApiController@getTags');
    Route::get('abilities', 'ApiController@getAbilities');
    Route::get('entity/get/{id}', 'ApiController@getGetOneAnticafeOrEvent');
    Route::get('profile', 'ApiController@getProfile');
    Route::get('cities', 'ApiController@cities');
    Route::post('profile-update', 'ApiController@postProfileUpdate');
    Route::post('search', 'ApiController@postSearch');
    Route::post('search-by-tag', 'ApiController@postFindByTag');
    Route::get('booking/get/{id}', 'ApiController@getClientBooking');
    Route::post('booking', 'ApiController@postBooking');
    Route::get('booking/delete/{id}', 'ApiController@getDeleteBooking');
    Route::post('like', 'ApiController@postLike');
    Route::post('prepaid', 'ApiController@postPrepaid');
    Route::post('login', 'ApiController@postLogin');
    Route::post('register', 'ApiController@postRegister');
    Route::post('register-device', 'ApiController@postRegisterDevice');
    Route::post('unregister-device', 'ApiController@postUnregisterDevice');

    Route::controller('v2', '\Anticafe\Http\Api\ApiController');
});

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
            'notifications' => 'NotificationsController',
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
        Route::get('notifications', [
            'as' => 'notifications', 'uses' => 'NotificationsController@getIndex'
        ]);
        Route::post('bookings/change-statuses', [
            'as' => 'bookings.status', 'uses' => 'BookingsController@postChangeStatus'
        ]);
        Route::get('/', 'StatisticsController@getIndex');
        Route::get('documentation', [
            'as' => 'api.doc', 'uses' => 'ApiController@documentation'
        ]);
    });
});

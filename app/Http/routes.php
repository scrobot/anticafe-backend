<?php

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

Route::post('/login', '\Anticafe\Http\Controllers\Auth\AuthController@postLogin');
Route::get('/login', '\Anticafe\Http\Controllers\Auth\AuthController@getLogin');



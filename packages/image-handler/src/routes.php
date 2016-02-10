<?php

Route::group(['prefix' => 'handlers', 'middleware' => 'auth'], function () {
    Route::controllers([
        'images' => '\Pinerp\ImageHandler\ImageHandlerController'
    ]);
});
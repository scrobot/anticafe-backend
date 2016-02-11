<?php

Route::get('/handlers/images/display/{_session}', '\Helpers\ImageHandler\ImageHandlerController@getDisplay');

Route::group(['prefix' => 'handlers'], function () {
    Route::controllers([
        'images' => '\Helpers\ImageHandler\ImageHandlerController'
    ]);
});

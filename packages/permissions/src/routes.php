<?php
Route::group(['middleware' => 'auth'], function () {
    Route::controllers([
        'permissions' => '\Anticafe\Packages\PermissionsController'
    ]);
});
<?php
Route::group(['middleware' => ['web', 'auth']], function () {
    Route::controllers([
        'permissions' => \Helpers\Permissions\PermissionsController::class
    ]);
    Route::get('permissions', ['as' => 'permissions', 'uses' => '\Helpers\Permissions\PermissionsController@getIndex']);
});
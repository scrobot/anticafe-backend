<?php
Route::group(['middleware' => ['web', 'auth']], function () {
    Route::controllers([
        'roles' => \Helpers\Roles\RoleController::class
    ]);
    Route::get('roles', ['as' => 'roles', 'uses' => '\Helpers\Roles\RoleController@getIndex']);
});
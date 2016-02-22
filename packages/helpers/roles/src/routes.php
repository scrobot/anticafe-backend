<?php
Route::group(['middleware' => ['web', 'auth']], function () {
    Route::controllers([
        'roles' => \Helpers\Roles\RoleController::class
    ]);
});
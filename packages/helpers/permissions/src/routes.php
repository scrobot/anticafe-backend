<?php
Route::group(['middleware' => ['web', 'auth']], function () {
    Route::controllers([
        'permissions' => \Helpers\Permissions\PermissionsController::class
    ]);
});
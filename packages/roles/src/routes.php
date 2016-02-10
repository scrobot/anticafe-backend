<?php
Route::group(['prefix' => 'admin', 'middleware' => 'auth.staff'], function () {
    Route::controllers([
        'roles' => '\Yadeshevle\Roles\RoleController'
    ]);
});
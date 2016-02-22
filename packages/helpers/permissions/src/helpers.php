<?php

use Pinerp\Permissions\Permiter;
use Pinerp\Staff\Models\User;

if(!function_exists('can')) {
    function can($permission, $callback = null, $user = null, $operator = 'and')
    {
        return \Helpers\Permissions\Permiter::checkPermission($permission, $operator, false, $user, $callback);
    }
}

if(!function_exists('check_perm')) {
    function check_perm($permission, $callback = null, $user = null, $operator = 'and')
    {
        return \Helpers\Permissions\Permiter::checkPermission($permission, $operator, true, $user, $callback);
    }
}

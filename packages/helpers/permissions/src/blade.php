<?php

\Blade::directive('can', function($permission_id, $callback = null, $user, $operator = 'and') {
    return can($permission_id, $callback, $user, $operator, false);
});
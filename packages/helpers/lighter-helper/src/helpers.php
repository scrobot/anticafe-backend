<?php

use Helpers\Lighter\Lighter;

function light_action($action, $attribute = null)
{
    return app(Lighter::class)->lightOnAction($action, $attribute);
}

function light_route($route, $attribute = null)
{
    return app(Lighter::class)->lightOnRoute($route, $attribute);
}

function light_event($event, $attribute = null)
{
    return app(Lighter::class)->lightOnEvent($event, $attribute);
}
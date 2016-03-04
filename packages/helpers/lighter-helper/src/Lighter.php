<?php

namespace Helpers\Lighter;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;

class Lighter
{

    /**
     * @type
     */
    public $firing = [ ];

    /**
     * @type string
     */
    protected $attribute = 'class="select active"';

    /**
     * @return string
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param string $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    public function lightOnAction($action, $attribute = null)
    {
        if(!$attribute){
            $attribute = $this->attribute;
        }

        //return ($attribute);

        if (!is_array($action)) {
            $action = [ $action ];
        }

        $current = \Route::currentRouteAction();
        /*        dd($action);
                dd($current);*/
        foreach ($action as $one) {
            if (str_contains($current, $one)) {
                return ($attribute);
            }
        }

        return null;
    }

    public function lightOnRoute($route, $attribute = null)
    {
        if(!$attribute){
            $attribute = $this->attribute;
        }
        if (!is_array($route)) {
            $route = [ $route ];
        }

        $current = \Route::currentRouteName();
        foreach ($route as $one) {
            if (str_contains($current, $one)) {
                return ($attribute);
            }
        }

        return null;
    }

    public function lightOnEvent($event, $attribute = null)
    {
        if(!$attribute){
            $attribute = $this->attribute;
        }
        if (!is_array($event)) {
            $event = [ $event ];
        }

        foreach ($event as $one) {
            if (in_array($one, $this->firing)) {
                return ($attribute);
            }
        }

        return null;
    }

    public function handleEvent($event)
    {
        $this->firing[] = $event;
    }

}
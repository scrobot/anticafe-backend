<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 24.06.2016
 * Time: 15:01
 */

namespace Anticafe\Http\Api;


use Illuminate\Support\Collection;

class Body
{

    /**
     * @var Collection
     */
    public $anticafe;

    /**
     * @var Collection
     */
    public $events;
    
    /**
     * @var collection
     */
    public $tags;

    /**
     * @var collection
     */
    public $bookings;
    
}
<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 10.02.2016
 * Time: 13:46
 */

namespace Anticafe\Http\Interfaces;


interface ModelNameable
{

    public function setModelName();

    public static function getModelName();

}
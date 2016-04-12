<?php namespace Anticafe\Http\Helpers;

/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 12.04.2016
 * Time: 16:32
 */
class PincodeGenerator
{

    public static function generate()
    {
        $int = rand(0, 9999);

        if($int < 10) {
            $int = "000".$int;
        } elseif($int < 100) {
            $int = "00".$int;
        } elseif($int < 1000) {
            $int = "0".$int;
        }

        return $int;
    }

}
<?php

namespace Anticafe\Http\Traits;


trait ListTrait
{

    public static function getList($name)
    {
        $list = [
            0 => "Все"
        ];

        foreach (static::all() as $item) {
            if($item->$name != null) {
                $list[$item->id] = "{$item->id} | " . $item->$name;
            } else {
                $list[$item->id] = "{$item->id} | " . $item->first_name . " " . $item->last_name;
            }
        }

        return $list;
    }
    
}
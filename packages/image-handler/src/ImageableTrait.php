<?php

namespace Pinerp\ImageHandler;

trait ImageableTrait {

    public function images()
    {
        return $this->morphMany('Pinerp\ImageHandler\ImageHandler', 'imageable');
    }

    public function preview($attributes = [])
    {
        $image = $this->images->first()->filename;
        if(empty($attributes) || count($attributes) < 2) {
            return uploads().$image;
        }

        return uploads()
                .$attributes[0]
                ."x"
                .$attributes[1]
                ."_"
                .$image;
    }

}
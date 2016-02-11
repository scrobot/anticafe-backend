<?php

namespace Helpers\ImageHandler;

trait ImageableTrait {

    public function images()
    {
        return $this->morphMany(ImageHandler::class, 'imageable');
    }

    public function preview($thumb = null)
    {
        $image = $this->images->where('preview', 1)->first();

        if(is_null($image)) {
            return "/images/no-image.png";
        }

        if(!is_null($thumb)) {
            return $image->preferences[$thumb];
        }

        return $image->preferences['preview'];
    }

    public function session_token()
    {
        if(!count($this->images)) {
            return false;
        }
        $image = $this->images->first();
        return $image->session_token;
    }

}
<?php

if(!function_exists('image_handler_widget')) {
    function image_handler_widget($object)
    {
        return view('image_handler::upload_widget')->withObject($object);
    }
}

if(!function_exists('uploads')) {
    function uploads() {
        return DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR;
    }
}

if(!function_exists('upload_path')) {
    function upload_path() {
        return public_path().DIRECTORY_SEPARATOR."uploads";
    }
}
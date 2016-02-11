<?php

if(!function_exists('image_handler_widget')) {
    function image_handler_widget($path = 'trash', $object)
    {
        $view = view('image_handler::upload_widget')->withObject($object)->withFolder($path);
        return $view->render();
    }
}

if(!function_exists('uploads')) {
    function uploads() {
        return DIRECTORY_SEPARATOR."images/anticafes";
    }
}

if(!function_exists('upload_path')) {
    function upload_path() {
        return public_path().DIRECTORY_SEPARATOR."images/anticafes";
    }
}

if(!function_exists('path_exists')) {
    function path_exists($path) {

        is_dir($path) ?: mkdir($path);

    }
}

if(!function_exists('sanitize')) {
    function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "?��", "?��", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }
}
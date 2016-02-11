<?php

\Blade::directive('handlerWidget', function($object = null) {
    return "<? echo image_handler_widget{$object}; ?>";
});
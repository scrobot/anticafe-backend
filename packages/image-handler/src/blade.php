<?php

\Blade::directive('handlerWidget', function($object) {
    return "<? echo image_handler_widget{$object}; ?>";
});
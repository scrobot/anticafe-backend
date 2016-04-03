<?php

Blade::directive('lightAction', function($action) {
    return "<?php echo light_action{$action} ?>";
});

Blade::directive('lightRoute', function($route) {
    return "<?php echo light_route{$route} ?>";
});

Blade::directive('lightEvent', function($event) {
    return "<?php echo light_event{$event} ?>";
});

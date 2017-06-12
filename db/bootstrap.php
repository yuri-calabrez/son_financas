<?php

use SONFin\Application;
use SONFin\Plugins\{DbPlugin, AuthPlugin};
use SONFin\ServiceContainer;

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);

$app->plugin(new DbPlugin());
$app->plugin(new AuthPlugin());

return $app;
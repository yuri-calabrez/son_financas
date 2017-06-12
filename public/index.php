<?php

use Dotenv\Dotenv;
use SONFin\Application;
use SONFin\Plugins\{RoutePlugin, ViewPlugin, DbPlugin, AuthPlugin};
use SONFin\ServiceContainer;

require __DIR__.'/../vendor/autoload.php';

if(file_exists(__DIR__.'/../.env')) {
    $dotEnv = new Dotenv(__DIR__.'/../');
    $dotEnv->overLoad();
}

require_once __DIR__.'/../src/helpers.php';

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);

$app->plugin(new RoutePlugin());
$app->plugin(new ViewPlugin());
$app->plugin(new DbPlugin());
$app->plugin(new AuthPlugin());

require_once __DIR__.'/../src/controllers/charts.php';
require_once __DIR__.'/../src/controllers/statements.php';
require_once __DIR__.'/../src/controllers/category-costs.php';
require_once __DIR__.'/../src/controllers/bill-receives.php';
require_once __DIR__.'/../src/controllers/bill-pays.php';
require_once __DIR__.'/../src/controllers/users.php';
require_once __DIR__.'/../src/controllers/auth.php';

$app->start();
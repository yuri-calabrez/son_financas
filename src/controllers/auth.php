<?php

use Psr\Http\Message\ServerRequestInterface;

$app->get(
    '/login', function () use ($app) {
        $view = $app->service('view.renderer');
        return $view->render('auth/login.html.twig');
    }, 'auth.login_form'
);

$app->post(
    '/login', function (ServerRequestInterface $request) use ($app) {
        $auth = $app->service('auth');
        $view = $app->service('view.renderer');
        $data = $request->getParsedBody();
        $result =  $auth->login($data);
        if(!$result) {
             return $view->render('auth/login.html.twig');
        }
        return $app->route('category-cost.list');
    }, 'auth.login'
);

$app->get(
    '/logout', function () use ($app) {
        $app->service('auth')->logout();
        return $app->route('auth.login_form');
    }, 'auth.logout'
);

$app->before(
    function () use ($app) {
        $route = $app->service('route');
        $auth = $app->service('auth');

        $routeWhiteList = [
        'auth.login_form',
        'auth.login'
        ];

        if (!in_array($route->name, $routeWhiteList) && !$auth->check()) {
            return $app->route('auth.login_form');
        }
    }
);

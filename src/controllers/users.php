<?php

use Psr\Http\Message\ServerRequestInterface;

$app->get(
    '/users', function () use ($app) {
        $repository = $app->service('user.repository');
        $users = $repository->all();
        $view = $app->service('view.renderer');
        return $view->render('users/list.html.twig', ['users' =>$users]);
    }, 'users.list'
);

$app->get(
    '/users/new', function () use ($app) {
        $view = $app->service('view.renderer');
        return $view->render('users/create.html.twig');
    }, 'users.new'
);

$app->post(
    '/users/store', function (ServerRequestInterface $request) use ($app) {
        $data = $request->getParsedBody();
        $repository = $app->service('user.repository');
        $auth = $app->service('auth');
        $data['password'] = $auth->hashPassword($data['password']);
        $repository->create($data);
        return $app->route('users.list');
    }, 'users.store'
);

$app->get(
    '/users/{id}/edit', function (ServerRequestInterface $request) use ($app) {
        $view = $app->service('view.renderer');
        $id = $request->getAttribute('id');
        $repository = $app->service('user.repository');
        $user =  $repository->find($id);
        return $view->render('users/edit.html.twig', compact('user'));
    }, 'users.edit'
);

$app->post(
    '/users/{id}/update', function (ServerRequestInterface $request) use ($app) {
        $id = $request->getAttribute('id');
        $data = $request->getParsedBody();
        $repository = $app->service('user.repository');
        if(isset($data['password'])){
            unset($data['password']);
        }
        $repository->update($id, $data);
        return $app->route('users.list');
    }, 'users.update'
);

$app->get(
    '/users/{id}/delete', function (ServerRequestInterface $request) use ($app) {
        $id = $request->getAttribute('id');
        $repository = $app->service('user.repository');
        $repository->delete($id);
        return $app->route('users.list');
    }, 'users.delete'
);

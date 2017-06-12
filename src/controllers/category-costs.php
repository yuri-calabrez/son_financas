<?php

use Psr\Http\Message\ServerRequestInterface;

$app->get(
    '/category-cost', function () use ($app) {
        $repository = $app->service('category-cost.repository');
        $auth = $app->service('auth');
        $categories = $repository->findByField('user_id', $auth->user()->getId());
        $view = $app->service('view.renderer');
        return $view->render('category-costs/list.html.twig', ['categories' => $categories]);
    }, 'category-cost.list'
);

$app->get(
    '/category-cost/new', function () use ($app) {
        $view = $app->service('view.renderer');
        return $view->render('category-costs/create.html.twig');
    }, 'category-cost.new'
);

$app->post(
    '/category-cost/store', function (ServerRequestInterface $request) use ($app) {
        $data = $request->getParsedBody();
        $repository = $app->service('category-cost.repository');
        $auth = $app->service('auth');
        $data['user_id'] =  $auth->user()->getId();
        $repository->create($data);
        return $app->route('category-cost.list');
    }, 'category-cost.store'
);

$app->get(
    '/category-cost/{id}/edit', function (ServerRequestInterface $request) use ($app) {
        $view = $app->service('view.renderer');
        $id = $request->getAttribute('id');
        $repository = $app->service('category-cost.repository');
        $auth = $app->service('auth');
        $category =  $repository->findOneBy(['id' => $id, 'user_id' => $auth->user()->getId()]);
        return $view->render('category-costs/edit.html.twig', compact('category'));
    }, 'category-cost.edit'
);

$app->post(
    '/category-cost/{id}/update', function (ServerRequestInterface $request) use ($app) {
        $id = $request->getAttribute('id');
        $data = $request->getParsedBody();
        $auth = $app->service('auth');
        $data['user_id'] =  $auth->user()->getId();
        $repository = $app->service('category-cost.repository');
        $repository->update(['id' => $id, 'user_id' => $auth->user()->getId()], $data);
        return $app->route('category-cost.list');
    }, 'category-cost.update'
);

$app->get(
    '/category-cost/{id}/delete', function (ServerRequestInterface $request) use ($app) {
        $id = $request->getAttribute('id');
        $repository = $app->service('category-cost.repository');
        $auth = $app->service('auth');
        $repository->delete(['id' => $id, 'user_id' => $auth->user()->getId()]);
        return $app->route('category-cost.list');
    }, 'category-cost.delete'
);

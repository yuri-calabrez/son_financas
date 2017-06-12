<?php

use Psr\Http\Message\ServerRequestInterface;

$app->get(
    '/bill-receives', function () use ($app) {
        $repository = $app->service('bill-receive.repository');
        $auth = $app->service('auth');
        $bills = $repository->findByField('user_id', $auth->user()->getId());
        $view = $app->service('view.renderer');
        return $view->render('bill-receives/list.html.twig', ['bills' => $bills]);
    }, 'bill-receives.list'
);

$app->get(
    '/bill-receives/new', function () use ($app) {
        $view = $app->service('view.renderer');
        return $view->render('bill-receives/create.html.twig');
    }, 'bill-receives.new'
);

$app->post(
    '/bill-receives/store', function (ServerRequestInterface $request) use ($app) {
        $data = $request->getParsedBody();
        $repository = $app->service('bill-receive.repository');
        $auth = $app->service('auth');
        $data['user_id'] =  $auth->user()->getId();
        $data['date_launch'] = dateParse($data['date_launch']);
        $data['value'] = numberParse($data['value']);
        $repository->create($data);
        return $app->route('bill-receives.list');
    }, 'bill-receives.store'
);

$app->get(
    '/bill-receives/{id}/edit', function (ServerRequestInterface $request) use ($app) {
        $view = $app->service('view.renderer');
        $id = $request->getAttribute('id');
        $repository = $app->service('bill-receive.repository');
        $auth = $app->service('auth');
        $bill =  $repository->findOneBy(['id' => $id, 'user_id' => $auth->user()->getId()]);
        return $view->render('bill-receives/edit.html.twig', compact('bill'));
    }, 'bill-receives.edit'
);

$app->post(
    '/bill-receives/{id}/update', function (ServerRequestInterface $request) use ($app) {
        $id = $request->getAttribute('id');
        $data = $request->getParsedBody();
        $auth = $app->service('auth');
        $data['user_id'] =  $auth->user()->getId();
        $data['date_launch'] = dateParse($data['date_launch']);
        $data['value'] = numberParse($data['value']);
        $repository = $app->service('bill-receive.repository');
        $repository->update(['id' => $id, 'user_id' => $auth->user()->getId()], $data);
        return $app->route('bill-receives.list');
    }, 'bill-receives.update'
);

$app->get(
    '/bill-receives/{id}/delete', function (ServerRequestInterface $request) use ($app) {
        $id = $request->getAttribute('id');
        $repository = $app->service('bill-receive.repository');
        $auth = $app->service('auth');
        $repository->delete(['id' => $id, 'user_id' => $auth->user()->getId()]);
        return $app->route('bill-receives.list');
    }, 'bill-receives.delete'
);

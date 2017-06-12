<?php
declare(strict_types = 1);
namespace SONFin\Plugins;


use Illuminate\Database\Capsule\Manager as Capsule;
use Interop\Container\ContainerInterface;
use SONFin\Models\{BillReceive, BillPay, CategoryCost, User};
use SONFin\Repository\{RepositoryFactory, StatementRepository, CategoryCostRepository};
use SONFin\ServiceContainerInterface;
use SONFin\View\ViewRenderer;

class DbPlugin implements PluginInterface
{
    public function register(ServiceContainerInterface $containerInterface)
    {
        $capsule = new Capsule();
        $config = include __DIR__.'/../../config/db.php';
        $capsule->addConnection($config['default_connection']);
        $capsule->bootEloquent(); 

        $containerInterface->add('repository.factory', new RepositoryFactory());
        $containerInterface->addLazy(
            'category-cost.repository', function () {
                return new CategoryCostRepository();
            }
        );
         $containerInterface->addLazy(
             'bill-receive.repository', function (ContainerInterface $c) {
                return $c->get('repository.factory')->factory(BillReceive::class);
             }
         );

         $containerInterface->addLazy(
             'bill-pay.repository', function (ContainerInterface $c) {
                return $c->get('repository.factory')->factory(BillPay::class);
             }
         );
        $containerInterface->addLazy(
            'user.repository', function (ContainerInterface $c) {
                return $c->get('repository.factory')->factory(User::class);
            }
        );

        $containerInterface->addLazy(
            'statement.repository', function () {
                return new StatementRepository();
            }
        );
    }
}

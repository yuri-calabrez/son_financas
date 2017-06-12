<?php
declare(strict_types = 1);
namespace SONFin\Plugins;


use Interop\Container\ContainerInterface;
use SONFin\Auth\Auth;
use SONFin\Auth\JasnyAuth;
use SONFin\ServiceContainerInterface;

class AuthPlugin implements PluginInterface
{
    public function register(ServiceContainerInterface $containerInterface)
    {
        $containerInterface->addLazy(
            'jasny.auth', function (ContainerInterface $c) {
                return new JasnyAuth($c->get('user.repository'));
            }
        );

        $containerInterface->addLazy(
            'auth', function (ContainerInterface $c) {
                return new Auth($c->get('jasny.auth'));
            }
        );
    }
}

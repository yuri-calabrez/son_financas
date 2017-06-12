<?php
declare(strict_types = 1);
namespace SONFin\Plugins;


use Aura\Router\RouterContainer;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use SONFin\ServiceContainerInterface;
use Zend\Diactoros\ServerRequestFactory;

class RoutePlugin implements PluginInterface
{
    public function register(ServiceContainerInterface $containerInterface)
    {
        $routerContainer = new RouterContainer();
        /* Registraras rotasdaaplicação */
        $map = $routerContainer->getMap();
        /* Tem a função de identificara rota queesta sendo acessada */
        $matcher = $routerContainer->getMatcher();
        /* Tem a função de gerar links com base nas rotas registradas */
        $generator = $routerContainer->getGenerator();
        $request = $this->getRequest();

        $containerInterface->add('routing', $map);
        $containerInterface->add('routing.matcher', $matcher);
        $containerInterface->add('routing.generator', $generator);
        $containerInterface->add(RequestInterface::class, $request);
        $containerInterface->addLazy(
            'route', function (ContainerInterface $container) {
                $matcher = $container->get('routing.matcher');
                $request = $container->get(RequestInterface::class);
                return $matcher->match($request); 
            }
        );
    }

    protected function getRequest(): RequestInterface
    {
        return ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);   
    }
}

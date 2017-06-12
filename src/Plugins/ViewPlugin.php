<?php
declare(strict_types = 1);
namespace SONFin\Plugins;


use Interop\Container\ContainerInterface;
use SONFin\ServiceContainerInterface;
use SONFin\View\Twig\TwigGlobals;
use SONFin\View\ViewRenderer;

class ViewPlugin implements PluginInterface
{
    public function register(ServiceContainerInterface $containerInterface)
    {
        $containerInterface->addLazy(
            'twig', function (ContainerInterface $c) {
                $loader = new \Twig_Loader_Filesystem(__DIR__.'/../../templates');
                $twig = new \Twig_Environment($loader);

                $auth = $c->get('auth');

                $generator = $c->get('routing.generator');
                $twig->addExtension(new TwigGlobals($auth));
                $twig->addFunction(
                    new \Twig_SimpleFunction(
                        'route', function (string $name, array $params = []) use ($generator) {
                            return $generator->generate($name, $params);
                        }
                    )
                );

                return $twig;
            }
        );  

        $containerInterface->addLazy(
            'view.renderer', function (ContainerInterface $c) {
                $twig = $c->get('twig');
                return new ViewRenderer($twig);
            }
        );

    }
}

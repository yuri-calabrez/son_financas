<?php
declare(strict_types = 1);
namespace SONFin\View;


use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;


class ViewRenderer implements ViewRendererInterface
{
    private $twig;

    function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function render(string $template, array $context = []): ResponseInterface
    {
        $result = $this->twig->render($template, $context);
        $response = new Response();
        $response->getBody()->write($result);
        return$response;
    }
}

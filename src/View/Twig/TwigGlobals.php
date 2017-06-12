<?php

namespace SONFin\View\Twig;

use SONFin\Auth\AuthInterface;



class TwigGlobals extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    private $auth;

    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }

    public function getGlobals()
    {
        return [
            'Auth' => $this->auth
        ];
    }
}

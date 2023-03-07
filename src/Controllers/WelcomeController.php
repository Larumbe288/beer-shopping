<?php

namespace Controllers;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

class WelcomeController
{
    public function __invoke(): ResponseInterface
    {
        $r = new Response();
        $r->getBody()->write("Hello world!");
        return $r;
    }
}
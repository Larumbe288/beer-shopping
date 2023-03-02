<?php

namespace Controllers;

use Slim\Psr7\Response;

class WelcomeController
{
    public function __invoke(): Response
    {
        $r = new Response();
        $r->getBody()->write("Hello world!");
        return $r;
    }
}
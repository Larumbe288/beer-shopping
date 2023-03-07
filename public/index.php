<?php

use Controllers\WelcomeController;
use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

require __DIR__ . '/../vendor/autoload.php';
require "../src/Controllers/WelcomeController.php";
$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$welcomeController = new WelcomeController();
$r = $welcomeController();
$app->get("/welcome", function (Response $response, Request $request) {
    $response->getBody()->write("Hello, world");
    return $response;
});
$app->run();

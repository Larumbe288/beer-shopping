<?php

use Controllers\WelcomeController;
use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

require __DIR__ . '/../vendor/autoload.php';
$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get("/welcome/{name}", function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello " . $args["name"]);
    return $response;
});
$app->run();

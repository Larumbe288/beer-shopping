<?php


use DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
$container = new Container();
$app = AppFactory::createFromContainer($container);


$app->run();





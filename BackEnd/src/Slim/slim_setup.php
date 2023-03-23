<?php


use BeerApi\Shopping\DependencyServices\CategoriesProvider as ContainerCategories;
use BeerApi\Shopping\RouteProvider\CategoriesProvider;
use Slim\App;


$app = new App();
// Set up dependencies
/** @var Container $container */
$container = $app->getContainer();
$container->register(new ContainerCategories());

// Error handle config
if ($container['appConfig']->isDevStage()) {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

// Register routes
$app->add();
$app->registerRouteProvider(new PingProvider());
$app->registerRouteProvider(new OpenApiProvider());
$app->registerRouteProvider(new CategoriesProvider());
return $app;
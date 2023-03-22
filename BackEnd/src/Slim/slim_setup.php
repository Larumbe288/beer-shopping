<?php


use BeerApi\Shopping\DependencyServices\CategoriesProvider as ContainerCategories;
use BeerApi\Shopping\RouteProvider\CategoriesProvider;
use Monolog\ErrorHandler;
use Ngcs\Slim\CustomSlimApp;
use Ngcs\Slim\DependecyServices\SlimDefaultProvider;
use Ngcs\Slim\Middleware\Auth\Oauth2;
use Ngcs\Slim\Middleware\ClientIpAddress;
use Ngcs\Slim\RouteProvider\OpenApiProvider;
use Ngcs\Slim\RouteProvider\PingProvider;
use Pimple\Container;


// Instantiate the app
$settings = [
    'settings' => [
        'displayErrorDetails' => false,
        'addContentLengthHeader' => false // Allow the web server to send the content-length header
    ]
];

$app = new CustomSlimApp($settings);
// Set up dependencies
/** @var Container $container */
$container = $app->getContainer();
$container->register(new SlimDefaultProvider());
$container->register(new ContainerCategories());

// Error handle config
if ($container['appConfig']->isDevStage()) {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}
$handler = new ErrorHandler($container['phpLogger']);
$handler->registerErrorHandler([], false);
$handler->registerExceptionHandler();
$handler->registerFatalHandler();

// Register middleware
$app->add($container[SlimDefaultProvider::API_LOGGER_TAG]);
$app->add(new Oauth2($container['Oauth2ResourceServer'], array('/'), array('/ping', '/info')));
$app->add(new ClientIpAddress('client_ip', array(), array(), false));

// Register routes
$app->registerRouteProvider(new PingProvider());
$app->registerRouteProvider(new OpenApiProvider());
$app->registerRouteProvider(new CategoriesProvider());
return $app;
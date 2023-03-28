<?php


require __DIR__ . '/../vendor/autoload.php';

use BeerApi\Shopping\Categories\Domain\Repositories\CategoryRepository;
use BeerApi\Shopping\DependencyServices\CategoriesProvider;
use BeerApi\Shopping\DependencyServices\UsersProvider;
use BeerApi\Shopping\Users\Domain\Repositories\UsersRepository;
use DI\Container;
use Slim\Factory\AppFactory;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$container = new Container();
$cat = new CategoriesProvider($container);
$container = $cat->register();
$users = new UsersProvider($container);
$container = $users->register();

$app = AppFactory::createFromContainer($container);

$app->get("/categories", function (Request $request, Response $response, array $args) use ($container) {
    $repository = $container->get(CategoryRepository::class);
    $response->getBody()->write(json_encode($repository->findAll('name', 19, 25)));
    return $response;
});

$app->get("/users", function (Request $request, Response $response, array $args) use ($container) {
    $repo = $container->get(UsersRepository::class);
    $response->getBody()->write(json_encode($repo->findAll('email', 32, 42)));
    return $response;
});
$app->run();

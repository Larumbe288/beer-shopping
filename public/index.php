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
    $categories = $repository->findAll('name', 0, 1000000000);
    $response->getBody()->write(json_encode(array('items' => $categories)));
    return $response;
});

$app->get("/users", function (Request $request, Response $response, array $args) use ($container) {
    $repo = $container->get(UsersRepository::class);
    $users = $repo->findAll('email', 0, 100000000000000000);
    $response->getBody()->write(json_encode(array("items" => $users)));
    return $response;
});

$app->get("/search", function (Request $request, Response $response, array $args) {
    $queryParams = $request->getQueryParams();
    $term = $queryParams['q'];
    $term2 = $queryParams['s'];
    $response->getBody()->write(json_encode(array($term => $term2)));
    return $response;
});
$app->run();

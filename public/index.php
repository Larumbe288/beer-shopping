<?php


require __DIR__ . '/../vendor/autoload.php';

use BeerApi\Shopping\Beers\Domain\Exceptions\BeerNotFound;
use BeerApi\Shopping\Beers\Domain\Readers\BeerSearcher;
use BeerApi\Shopping\Beers\Domain\Repositories\BeerRepository;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerId;
use BeerApi\Shopping\Categories\Application\CategoryDeleter;
use BeerApi\Shopping\Categories\Domain\Repositories\CategoryRepository;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryId;
use BeerApi\Shopping\Categories\Infrastucture\Repositories\MySQLCategoryRepository;
use BeerApi\Shopping\Controllers\Beers\PostBeers;
use BeerApi\Shopping\Controllers\Beers\PutBeers;
use BeerApi\Shopping\Controllers\Categories\PostCategories;
use BeerApi\Shopping\Controllers\Categories\PutCategories;
use BeerApi\Shopping\Controllers\Users\DeleteUsers;
use BeerApi\Shopping\Controllers\Users\PostUsers;
use BeerApi\Shopping\Controllers\Users\PutUsers;
use BeerApi\Shopping\DependencyServices\BeersProvider;
use BeerApi\Shopping\DependencyServices\CategoriesProvider;
use BeerApi\Shopping\DependencyServices\UsersProvider;
use BeerApi\Shopping\Users\Domain\Repositories\AutenticatorRepository;
use BeerApi\Shopping\Users\Domain\Repositories\UsersRepository;
use BeerApi\Shopping\Users\Domain\ValueObject\UserEmail;
use BeerApi\Shopping\Users\Domain\ValueObject\UserId;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPassword;
use DI\Container;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Access-Control-Allow-Credentials: true');
header('Content-type: application/json');


$container = new Container();
$cat = new CategoriesProvider($container);
$container = $cat->register();
$users = new UsersProvider($container);
$container = $users->register();
$beers = new BeersProvider($container);
$container = $beers->register();

$app = AppFactory::createFromContainer($container);
$app->addBodyParsingMiddleware();
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8888')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});
$app->get("/ping", function (Request $request, Response $response, array $args) {
    $response->getBody()->write(json_encode(array("PONG")));
    return $response;
});

$app->post("/categories", function (Request $request, Response $response, array $args) use ($container) {
    $postCat = new PostCategories($container);
    $cat = $postCat->__invoke($request, $response, $args);
    $response->getBody()->write(json_encode($cat));
    return $response;
});
$app->put("/categories/{id}", function (Request $request, Response $response, array $args) use ($container) {
    $putCat = new PutCategories($container);
    $cat = $putCat->__invoke($request, $response, $args);
    $response->getBody()->write(json_encode($cat));
    return $response;
});
$app->get("/categories", function (Request $request, Response $response, array $args) use ($container) {
    $repository = $container->get(CategoryRepository::class);
    $repo = new MySQLCategoryRepository();
    $max = $repo->getNumberCategories();
    $queryParams = $request->getQueryParams();
    if (isset($queryParams['begin'])) {
        $begin = (int)$queryParams['begin'];
    } else {
        $begin = 0;
    }
    if (isset($queryParams['end'])) {
        $end = (int)$queryParams['end'];
    } else {
        $end = 10;
    }
    $categories = $repository->findAll('name', $begin, $end);
    $response->getBody()->write(json_encode(array('items' => $categories, 'prev_offset' => $begin, 'next_offset' => $end, "number" => $max)));
    return $response;
});
$app->delete("/categories/{id}", function (Request $request, Response $response, array $args) use ($container) {
    $id = new CategoryId($args['id']);
    /** @var CategoryDeleter $remover */
    $remover = $container->get(CategoryDeleter::class);
    $remover->__invoke($id);
    return $response->withStatus(204, 'Deleted');
});

$app->post('/users/login', function (Request $request, Response $response, array $args) use ($container) {
    $userEmail = new UserEmail($request->getParsedBody()['email']);
    $userPassword = new UserPassword($request->getParsedBody()['password']);
    $repo = $container->get(AutenticatorRepository::class);
    $bool = $repo->userLogin($userEmail, $userPassword);
    $response->getBody()->write(json_encode(array($bool)));
    return $response->withStatus(200);
});

$app->post('/users', function (Request $request, Response $response, array $args) use ($container) {
    $postUser = new PostUsers($container);
    $user = $postUser->__invoke($request, $response, $args);
    $response->getBody()->write(json_encode($user));
    return $response;
});

$app->get("/users", function (Request $request, Response $response, array $args) use ($container) {
    $repo = $container->get(UsersRepository::class);
    $users = $repo->findAll('email', 0, 10);
    $response->getBody()->write(json_encode(array("items" => $users)));
    return $response;
});
$app->delete("/users/{id}", function (Request $request, Response $response, array $args) use ($container) {
    $deleteController = new DeleteUsers($container);
    return $deleteController->__invoke($request, $response, $args);
});
$app->get("/users/{id}", function (Request $request, Response $response, array $args) use ($container) {
    /** @var UsersRepository $repo */
    $repo = $container->get(UsersRepository::class);
    $user = $repo->find(new UserId($args['id']));
    $response->getBody()->write(json_encode($user));
    return $response->withStatus(200);
});
$app->put("/users/{id}", function (Request $request, Response $response, array $args) use ($container) {
    $putController = new PutUsers($container);
    $user = $putController->__invoke($request, $response, $args);
    $response->getBody()->write(json_encode($user));
    return $response;
});
$app->get("/beers/search", function (Request $request, Response $response, array $args) use ($container) {
    $queryParams = $request->getQueryParams();
    $search = isset($queryParams['search']) ? $queryParams['search'] : "";
    $searcher = $container->get(BeerSearcher::class);
    $beers = $searcher->findBeerBySearch($search);
    $response->getBody()->write(json_encode(array('items' => $beers)));
    return $response;
});

$app->post("/beers", function (Request $request, Response $response, array $args) use ($container) {
    $postBeers = new PostBeers($container);
    $beer = $postBeers->__invoke($request, $response, $args);
    $response->getBody()->write(json_encode($beer));
    return $response->withStatus(201, 'Beer Created');
});

$app->put("/beers/{id}", function (Request $request, Response $response, array $args) use ($container) {
    $putBeers = new PutBeers($container);
    $beer = $putBeers->__invoke($request, $response, $args);
    $response->getBody()->write(json_encode($beer));
    return $response->withStatus(200, 'Beer Updated');
});
$app->get("/beers/{id}", function (Request $request, Response $response, array $args) use ($container) {
    $repoBeer = $container->get(BeerRepository::class);
    $beer = $repoBeer->find(new BeerId($args['id']));
    $response->getBody()->write(json_encode($beer));
    return $response->withStatus(200, 'Beer Found');
});

$app->get("/beers", function (Request $request, Response $response, array $args) use ($container) {
    $beerRepo = $container->get(BeerRepository::class);
    $begin = isset($request->getQueryParams()['begin']) ? (int)$request->getQueryParams()['begin'] : 0;
    $end = isset($request->getQueryParams()['end']) ? (int)$request->getQueryParams()['end'] : 15;

    $beersFound = $beerRepo->findAll('UUID', $begin, $end);
    $response->getBody()->write(json_encode(array('items' => $beersFound)));
    return $response->withStatus(200, 'Beers');
});

$app->delete("/beers/{id}", function (Request $request, Response $response, array $args) use ($container) {
    try {
        $repo = $container->get(BeerRepository::class);
        $repo->delete(new BeerId($args['id']));
        return $response->withStatus(204);
    } catch (BeerNotFound $e) {
        return $response->withStatus(404, "Not Found");
    } catch (InvalidArgumentException $invalidArgumentException) {
        return $response->withStatus(400, 'InvalidArguments');
    } catch (Throwable $e) {
        return $response->withStatus(500, 'Internal Error');
    }
});
$app->get("/beers/likes/{likes}", function (Request $request, Response $response, array $args) use ($container) {
    /** @var BeerSearcher $searcher */
    $searcher = $container->get(BeerSearcher::class);
    $beers = $searcher->findBeerByLikesOrMore((int)$args['likes']);
    $response->getBody()->write(json_encode(array("items" => $beers)));
    return $response->withStatus(200, 'Beers Liked');
});
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    throw new HttpNotFoundException($request);
});
$app->run();

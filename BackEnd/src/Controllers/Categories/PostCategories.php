<?php

namespace BeerApi\Shopping\Controllers\Categories;


use BeerApi\Shopping\Categories\Application\CategoryCreator;
use BeerApi\Shopping\Categories\Domain\Repositories\CategoryRepository;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryDescription;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryId;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryName;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * Class PostCategories
 * @package BeerApi\Shopping\Controllers\Categories
 */
class PostCategories
{
    private Container $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
        /** @var CategoryCreator $creator */
        $creator = $this->container->get(CategoryCreator::class);
        $subId = isset($request->getParsedBody()['idCat']) ? new CategoryId($request->getParsedBody()["idCat"]) : null;
        $id = $creator->__invoke(new CategoryName($request->getParsedBody()['name']), new CategoryDescription($request->getParsedBody()['description']), $subId);
        return $this->container->get(CategoryRepository::class)->findById($id);
    }
}
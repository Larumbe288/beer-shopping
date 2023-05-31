<?php

namespace BeerApi\Shopping\Controllers\Categories;

use BeerApi\Shopping\Categories\Application\CategoryFinder;
use BeerApi\Shopping\Categories\Application\CategoryUpdater;
use BeerApi\Shopping\Categories\Domain\Category;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryDescription;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryId;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryName;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * Class PutCategories
 * @package BeerApi\Shopping\Controllers\Categories
 */
class PutCategories
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
        $idCat = new CategoryId($args['id']);
        $updater = $this->container->get(CategoryUpdater::class);
        $name = new CategoryName($request->getParsedBody()['name']);
        $description = new CategoryDescription($request->getParsedBody()['description']);
        $subId = isset($request->getParsedBody()['idCat']) ? new CategoryId($request->getParsedBody()["idCat"]) : null;
        $cat = new Category($idCat, $name, $description, $subId);
        $updater->__invoke($cat);
        return $this->container->get(CategoryFinder::class)->__invoke($idCat);
    }
}
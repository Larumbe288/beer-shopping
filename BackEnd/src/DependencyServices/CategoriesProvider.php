<?php

namespace BeerApi\Shopping\DependencyServices;

use BeerApi\Shopping\Categories\Application\CategoryCreator;
use BeerApi\Shopping\Categories\Application\CategoryDeleter;
use BeerApi\Shopping\Categories\Application\CategoryFinder;
use BeerApi\Shopping\Categories\Application\CategoryUpdater;
use BeerApi\Shopping\Categories\Domain\Repositories\CategoryRepository;
use BeerApi\Shopping\Categories\Infrastucture\Repositories\MySQLCategoryRepository;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;

/**
 *
 */
class CategoriesProvider
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @throws NotFoundException
     * @throws DependencyException
     */
    public function register(): Container
    {
        $this->container->set(CategoryRepository::class, new MySQLCategoryRepository());
        $this->container->set(CategoryCreator::class, new CategoryCreator($this->container->get(CategoryRepository::class)));
        $this->container->set(CategoryFinder::class, new CategoryFinder($this->container->get(CategoryRepository::class)));
        $this->container->set(CategoryUpdater::class, new CategoryUpdater($this->container->get(CategoryRepository::class)));
        $this->container->set(CategoryDeleter::class, new CategoryDeleter($this->container->get(CategoryRepository::class)));
        return $this->container;
    }
}
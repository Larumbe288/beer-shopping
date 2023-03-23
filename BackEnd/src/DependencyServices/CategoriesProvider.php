<?php

namespace BeerApi\Shopping\DependencyServices;

use BeerApi\Shopping\Categories\Application\CategoryCreator;
use BeerApi\Shopping\Categories\Domain\Repositories\CategoryRepository;
use BeerApi\Shopping\Categories\Infrastucture\Repositories\InMemoryCategoryRepository;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 *
 */
class CategoriesProvider implements ServiceProviderInterface
{

    public function register(Container $container)
    {
        $container[CategoryRepository::class] = fn($container) => new InMemoryCategoryRepository([]);
        $container[CategoryCreator::class] = fn($container) => new CategoryCreator($container[CategoryRepository::class]);

    }
}
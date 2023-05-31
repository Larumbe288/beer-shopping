<?php

namespace BeerApi\Shopping\DependencyServices;

use BeerApi\Shopping\Beers\Application\BeerCreator;
use BeerApi\Shopping\Beers\Application\BeerDeleter;
use BeerApi\Shopping\Beers\Application\BeerFinder;
use BeerApi\Shopping\Beers\Application\BeerUpdater;
use BeerApi\Shopping\Beers\Domain\Readers\BeerSearcher;
use BeerApi\Shopping\Beers\Domain\Repositories\BeerRepository;
use BeerApi\Shopping\Beers\Infrastructure\MySqlBeerRepository;
use BeerApi\Shopping\Beers\Infrastructure\Readers\MySqlBeerSearcher;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;

/**
 * Class BeersProvider
 * @package BeerApi\Shopping\DependencyServices
 */
class BeersProvider
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
        $this->container->set(BeerRepository::class, new MySqlBeerRepository());
        $this->container->set(BeerCreator::class, new BeerCreator($this->container->get(BeerRepository::class)));
        $this->container->set(BeerUpdater::class, new BeerUpdater($this->container->get(BeerRepository::class)));
        $this->container->set(BeerFinder::class, new BeerFinder($this->container->get(BeerRepository::class)));
        $this->container->set(BeerDeleter::class, new BeerDeleter($this->container->get(BeerRepository::class)));
        $this->container->set(BeerSearcher::class, new MySqlBeerSearcher());
        return $this->container;
    }
}
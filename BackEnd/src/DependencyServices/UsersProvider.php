<?php

namespace BeerApi\Shopping\DependencyServices;

use BeerApi\Shopping\Users\Application\UserCreator;
use BeerApi\Shopping\Users\Application\UserDeleter;
use BeerApi\Shopping\Users\Application\UserFinder;
use BeerApi\Shopping\Users\Application\UserUpdater;
use BeerApi\Shopping\Users\Domain\Repositories\AutenticatorRepository;
use BeerApi\Shopping\Users\Domain\Repositories\UsersRepository;
use BeerApi\Shopping\Users\Infrastructure\MySQLAutenticatorRepository;
use BeerApi\Shopping\Users\Infrastructure\MySQLUsersRepository;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;

/**
 *
 */
class UsersProvider
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
        $this->container->set(AutenticatorRepository::class, new MySQLAutenticatorRepository());
        $this->container->set(UsersRepository::class, new MySQLUsersRepository());
        $this->container->set(UserCreator::class, new UserCreator($this->container->get(UsersRepository::class)));
        $this->container->set(UserFinder::class, new UserFinder($this->container->get(UsersRepository::class)));
        $this->container->set(UserUpdater::class, new UserUpdater($this->container->get(UsersRepository::class)));
        $this->container->set(UserDeleter::class, new UserDeleter($this->container->get(UsersRepository::class)));
        return $this->container;
    }
}
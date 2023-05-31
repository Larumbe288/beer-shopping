<?php

namespace BeerApi\Shopping\Controllers\Users;

use BeerApi\Shopping\Users\Application\UserFinder;
use BeerApi\Shopping\Users\Application\UserUpdater;
use BeerApi\Shopping\Users\Domain\User;
use BeerApi\Shopping\Users\Domain\ValueObject\UserAddress;
use BeerApi\Shopping\Users\Domain\ValueObject\UserBirthDate;
use BeerApi\Shopping\Users\Domain\ValueObject\UserEmail;
use BeerApi\Shopping\Users\Domain\ValueObject\UserId;
use BeerApi\Shopping\Users\Domain\ValueObject\UserName;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPassword;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPhone;
use BeerApi\Shopping\Users\Domain\ValueObject\UserRole;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * Class PutUsers
 * @package BeerApi\Shopping\Controllers\Users
 */
class PutUsers
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
    public function __invoke(Request $request, Response $response, array $args): User
    {
        /** @var UserUpdater $updater */
        $updater = $this->container->get(UserUpdater::class);
        /** @var UserFinder $finder */
        $finder = $this->container->get(UserFinder::class);
        $userId = new UserId($args['id']);
        $userName = new UserName($request->getParsedBody()['name']);
        $userEmail = new UserEmail($request->getParsedBody()['email']);
        $userPassword = new UserPassword('Alvaro1234');
        $userAddress = new UserAddress($request->getParsedBody()['address']);
        $userBirthDate = new UserBirthDate($request->getParsedBody()['date']);
        $userPhone = new UserPhone($request->getParsedBody()['phone']);
        $userRole = $finder->__invoke($userId)->getUserRole();
        $user = new User($userId, $userName, $userEmail, $userPassword, $userAddress, $userBirthDate, $userPhone, $userRole);
        $updater->__invoke($user);
        return $finder->__invoke($userId);
    }
}
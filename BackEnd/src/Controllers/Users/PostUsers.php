<?php

namespace BeerApi\Shopping\Controllers\Users;

use BeerApi\Shopping\Controllers\Shared\BaseController;
use BeerApi\Shopping\Users\Application\UserCreator;
use BeerApi\Shopping\Users\Domain\Repositories\UsersRepository;
use BeerApi\Shopping\Users\Domain\User;
use BeerApi\Shopping\Users\Domain\ValueObject\UserAddress;
use BeerApi\Shopping\Users\Domain\ValueObject\UserBirthDate;
use BeerApi\Shopping\Users\Domain\ValueObject\UserEmail;
use BeerApi\Shopping\Users\Domain\ValueObject\UserName;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPassword;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPhone;
use BeerApi\Shopping\Users\Domain\ValueObject\UserRole;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class PostUsers
 * @package BeerApi\Shopping\Controllers\Users
 */
class PostUsers implements BaseController
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return User
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response, array $args): User
    {
        $name = new UserName($request->getParsedBody()['name']);
        $email = new UserEmail($request->getParsedBody()['email']);
        $password = new UserPassword($request->getParsedBody()['password']);
        $address = new UserAddress($request->getParsedBody()['address']);
        $birth_date = new UserBirthDate($request->getParsedBody()['date']);
        $phone = new UserPhone($request->getParsedBody()['phone']);
        $role = new UserRole('user');
        /** @var UserCreator $creator */
        $creator = $this->container->get(UserCreator::class);
        $id = $creator->__invoke($name, $email, $password, $address, $birth_date, $phone, $role);
        /** @var UsersRepository $finder */
        $finder = $this->container->get(UsersRepository::class);
        return $finder->find($id);
    }
}
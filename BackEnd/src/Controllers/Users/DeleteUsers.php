<?php

namespace BeerApi\Shopping\Controllers\Users;

use BeerApi\Shopping\Controllers\Shared\BaseController;
use BeerApi\Shopping\Users\Application\UserDeleter;
use BeerApi\Shopping\Users\Domain\ValueObject\UserId;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class DeleteUsers
 * @package BeerApi\Shopping\Controllers\Users
 */
class DeleteUsers implements BaseController
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
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $remover = $this->container->get(UserDeleter::class);
        $remover->__invoke(new UserId($args['id']));
        return $response->withStatus(204, 'Deleted');
    }
}
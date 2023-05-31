<?php


namespace BeerApi\Shopping\Controllers\Shared;

use Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * Interface BaseController
 * @package BeerApi\Shopping\Controllers\Users
 */
interface BaseController
{
    public function __invoke(Request $request, Response $response, array $args);
}
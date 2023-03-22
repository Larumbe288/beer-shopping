<?php

namespace BeerApi\Shopping\RouteProvider;

use BeerApi\Shopping\Controllers\Categories\PostCategories;
use Ngcs\Slim\CustomSlimApp;
use Ngcs\Slim\Middleware\ScopeValidator;
use Ngcs\Slim\RouteHandler\IRouteProvider;

class CategoriesProvider implements IRouteProvider
{

    const READ_CATEGORIES = 'read_categories';
    const WRITE_CATEGORIES = 'write_categories';

    public function register(CustomSlimApp $slimApp)
    {
        $slimApp->post("/categories", PostCategories::class)->add(new ScopeValidator([self::READ_CATEGORIES, self::WRITE_CATEGORIES]));
    }
}
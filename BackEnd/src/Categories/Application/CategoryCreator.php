<?php

namespace BeerApi\Shopping\Categories\Application;

use BeerApi\Shopping\Categories\Domain\Category;
use BeerApi\Shopping\Categories\Domain\Repositories\CategoryRepository;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryDescription;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryId;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryName;
use Exception;

/**
 * Class CategoryCreator
 * @package BeerApi\Shopping\Categories\Application
 */
class CategoryCreator
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws Exception
     */
    public function __invoke(CategoryName $name, CategoryDescription $description, CategoryId $categoryId = null): CategoryId
    {
        $id = Category::create();
        $this->repository->insert(new Category($id, $name, $description, $categoryId));
        return $id;
    }
}
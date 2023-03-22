<?php

namespace BeerApi\Shopping\Categories\Application;

use BeerApi\Shopping\Categories\Domain\Category;
use BeerApi\Shopping\Categories\Domain\Repositories\CategoryRepository;
use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryDescription;
use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryId;
use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryName;
use Exception;

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
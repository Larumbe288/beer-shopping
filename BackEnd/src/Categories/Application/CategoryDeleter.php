<?php

namespace BeerApi\Shopping\Categories\Application;

use BeerApi\Shopping\Categories\Domain\Repositories\CategoryRepository;
use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryId;

class CategoryDeleter
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(CategoryId $categoryId)
    {
        $category = $this->categoryRepository->findById($categoryId);
        $category->delete();
    }
}
<?php

namespace BeerApi\Shopping\Categories\Application;

use BeerApi\Shopping\Categories\Domain\Category;
use BeerApi\Shopping\Categories\Domain\Repositories\CategoryRepository;

class CategoryUpdater
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(Category $category): void
    {
        $category = $this->categoryRepository->findById($category->getCategoryId());
        if (!is_null($category->getSubId())) {
            $category->update($category->getCategoryName(), $category->getCategoryDescription(), $category->getSubId());
        } else {
            $category->update($category->getCategoryName(), $category->getCategoryDescription());
        }
        $this->categoryRepository->update($category);
    }
}
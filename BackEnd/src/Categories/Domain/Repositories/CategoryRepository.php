<?php

namespace BeerApi\Shopping\Categories\Domain\Repositories;

use BeerApi\Shopping\Categories\Domain\Category;
use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryId;

/**
 *
 */
interface CategoryRepository
{
    public function insert(Category $category);

    public function update(Category $category);

    public function findById(CategoryId $categoryId);

    public function delete(CategoryId $categoryId);

    public function findAll();

}
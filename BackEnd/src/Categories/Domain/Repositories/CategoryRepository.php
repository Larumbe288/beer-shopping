<?php

namespace BeerApi\Shopping\Categories\Domain\Repositories;

use BeerApi\Shopping\Categories\Domain\Category;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryId;

/**
 *
 */
interface CategoryRepository
{
    public function insert(Category $category);

    public function update(Category $category);

    public function findById(CategoryId $categoryId): Category;

    public function delete(CategoryId $categoryId);

    public function findAll(string $field, int $prev_offset, int $next_offset);

}
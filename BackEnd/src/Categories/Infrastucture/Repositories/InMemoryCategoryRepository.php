<?php

namespace BeerApi\Shopping\Categories\Infrastucture\Repositories;

use BeerApi\Shopping\Categories\Domain\Category;
use BeerApi\Shopping\Categories\Domain\Repositories\CategoryRepository;
use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryId;
use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryName;

class InMemoryCategoryRepository implements CategoryRepository
{
    private array $memory;

    public function __construct(array $memory)
    {
        $this->memory = $memory;
    }

    public function insert(Category $category)
    {
        $this->memory = $this->array_push_assoc($this->memory, $category->getCategoryId(), $category);
    }

    public function update(Category $category)
    {
        // TODO: Implement update() method.
    }

    public function findById(CategoryId $categoryId)
    {
        // TODO: Implement findById() method.
    }

    public function delete(CategoryId $categoryId)
    {
        // TODO: Implement delete() method.
    }

    public function findAll()
    {
        return $this->memory;
    }

    private function checkName(CategoryName $name)
    {
        for ($i = 0; $i < count($this->memory); $i++) {

        }
    }

    /**
     * @param array $array
     * @param $key
     * @param $value
     * @return array
     */
    private function array_push_assoc(array $array, $key, $value): array
    {
        $array[$key] = $value;
        return $array;
    }
}
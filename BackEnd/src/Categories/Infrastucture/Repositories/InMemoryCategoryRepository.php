<?php

namespace BeerApi\Shopping\Categories\Infrastucture\Repositories;

use BeerApi\Shopping\Categories\Domain\Category;
use BeerApi\Shopping\Categories\Domain\Exceptions\CategoryAlreadyExists;
use BeerApi\Shopping\Categories\Domain\Exceptions\CategoryNotFound;
use BeerApi\Shopping\Categories\Domain\Repositories\CategoryRepository;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryId;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryName;

/**
 *
 */
class InMemoryCategoryRepository implements CategoryRepository
{
    /** @var Category[] */
    private array $memory;

    public function __construct(array $memory)
    {
        $this->memory = $memory;
    }

    /**
     * @throws CategoryAlreadyExists
     */
    public function insert(Category $category)
    {
        $this->checkName($category->getCategoryName());
        $this->memory = $this->array_push_assoc($this->memory, $category->getCategoryId()->getValue(), $category);
    }

    /**
     * @throws CategoryNotFound
     * @throws CategoryAlreadyExists
     */
    public function update(Category $category): void
    {
        $category = $this->findById($category->getCategoryId());
        $this->checkName($category->getCategoryName());
        $this->memory[$category->getCategoryId()->getValue()] = $category;
    }

    /**
     * @param CategoryId $categoryId
     * @return Category
     * @throws CategoryNotFound
     */
    public function findById(CategoryId $categoryId): Category
    {
        if (isset($this->memory[$categoryId->getValue()])) {
            return $this->memory[$categoryId->getValue()];
        }
        throw new CategoryNotFound();
    }

    /**
     * @throws CategoryNotFound
     */
    public function delete(CategoryId $categoryId): void
    {
        if (isset($this->memory[$categoryId->getValue()])) {
            unset($this->memory[$categoryId->getValue()]);
            return;
        }
        throw new CategoryNotFound();
    }

    /**
     * @return array|Category
     */
    public function findAll(string $field, int $prev_offset, int $next_offset): array|Category
    {
        return $this->memory;
    }

    /**
     * @throws CategoryAlreadyExists
     */
    private function checkName(CategoryName $name)
    {
        foreach ($this->memory as $key => $value) {
            if ($name->getValue() === $value->getCategoryName()->getValue()) {
                throw new CategoryAlreadyExists();
            }
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
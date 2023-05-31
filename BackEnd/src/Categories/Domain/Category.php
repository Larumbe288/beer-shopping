<?php

namespace BeerApi\Shopping\Categories\Domain;

use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryDescription;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryId;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryName;
use Exception;
use InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;

/**
 *
 */
class Category implements JsonSerializable
{
    private CategoryId $categoryId;
    private CategoryName $categoryName;
    private CategoryDescription $categoryDescription;
    private CategoryId|null $subId;

    public function __construct(CategoryId $categoryId, CategoryName $categoryName, CategoryDescription $categoryDescription, CategoryId|null $subCategoryId = null)
    {
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
        $this->categoryDescription = $categoryDescription;
        if ($subCategoryId !== null) {
            $this->subId = $subCategoryId;
        } else {
            $this->subId = null;
        }
    }

    /**
     * @throws Exception
     */
    public static function randomCategory(): Category
    {
        return new Category(CategoryId::generate(), CategoryName::randomName(), CategoryDescription::randomDescription());
    }

    /**
     * @return CategoryId
     */
    public function getCategoryId(): CategoryId
    {
        return $this->categoryId;
    }

    /**
     * @return CategoryName
     */
    public function getCategoryName(): CategoryName
    {
        return $this->categoryName;
    }

    /**
     * @return CategoryDescription
     */
    public function getCategoryDescription(): CategoryDescription
    {
        return $this->categoryDescription;
    }

    /**
     * @return CategoryId|null
     */
    public function getSubId(): CategoryId|null
    {
        return $this->subId;
    }


    /**
     * @return CategoryId
     * @throws Exception
     */
    public static function create(): CategoryId
    {
        return CategoryId::generate();
    }

    public function update(CategoryName $name, CategoryDescription $description, CategoryId $subId = null): Category
    {
        $this->categoryName = $name;
        $this->categoryDescription = $description;
        if (!is_null($subId)) {
            $this->subId = $subId;
        }
        return $this;
    }

    public function delete(): void
    {
        if ($this->hasProducts() || $this->isParentCategory()) {
            throw new InvalidArgumentException();
        }
    }

    private function hasProducts(): bool
    {
        return false;
    }

    private function isParentCategory(): bool
    {
        return false;
    }

    #[Pure] #[ArrayShape(["id" => "string", "properties" => "array"])] public function jsonSerialize(): array
    {
        if ($this->subId === null) {
            $array = array(
                "id" => $this->categoryId->getValue(),
                "properties" => array(
                    "name" => $this->categoryName->getValue(),
                    "description" => $this->categoryDescription->getValue(),
                )
            );
        } else {
            $array = array(
                "id" => $this->categoryId->getValue(),
                "properties" => array(
                    "name" => $this->categoryName->getValue(),
                    "description" => $this->categoryDescription->getValue(),
                    "subId" => $this->subId->getValue()
                )
            );
        }
        return $array;
    }
}
<?php

namespace BeerApi\Shopping\Categories\Domain;

use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryDescription;
use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryId;
use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryName;
use Exception;

/**
 *
 */
class Category
{
    private CategoryId $categoryId;
    private CategoryName $categoryName;
    private CategoryDescription $categoryDescription;
    private CategoryId $subId;

    public function __construct(CategoryId $categoryId, CategoryName $categoryName, CategoryDescription $categoryDescription, CategoryId $subCategoryId = null)
    {
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
        $this->categoryDescription = $categoryDescription;
        if ($subCategoryId !== null) {
            $this->subId = $subCategoryId;
        }
    }

    /**
     * @throws Exception
     */
    public static function randomCategory(): Category
    {
        return new Category(CategoryId::generate(), CategoryName::randomName(), CategoryDescription::randomDescription());
    }

    public function getCategoryId()
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
     * @return CategoryId
     */
    public function getSubId(): CategoryId
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

    public function update()
    {

    }
}
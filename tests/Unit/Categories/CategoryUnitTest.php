<?php

namespace Beer\Shopping\Test\Unit\Categories;

use BeerApi\Shopping\Categories\Application\CategoryCreator;
use BeerApi\Shopping\Categories\Application\CategoryFinder;
use BeerApi\Shopping\Categories\Application\CategoryUpdater;
use BeerApi\Shopping\Categories\Domain\Category;
use BeerApi\Shopping\Categories\Domain\Exceptions\CategoryAlreadyExists;
use BeerApi\Shopping\Categories\Domain\Exceptions\CategoryNotFound;
use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryDescription;
use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryId;
use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryName;
use BeerApi\Shopping\Categories\Infrastucture\Repositories\InMemoryCategoryRepository;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CategoryUnitTest extends TestCase
{

    private InMemoryCategoryRepository $repository;
    private string $description;
    private string $name;
    private CategoryId $id;

    /**
     * @throws Exception
     */
    public function testCreateACategoryWithInvalidNameReturnsInvalidArgumentException()
    {
        $this->givenAnInvalidNameOrDescription();
        self::expectException(InvalidArgumentException::class);
        $this->whenCreateCategory();
    }

    /**
     * @throws Exception
     */
    public function testCreateAValidCategoryIsSaved()
    {
        $this->givenAValidCategory();
        $this->whenCreateCategory();
        $this->thenCategoryIsSaved();
    }

    /**
     * @throws Exception
     */
    public function testANonExistingCategoryReturnsCategoryNotFound()
    {
        $this->givenANonExistingCategory();
        self::expectException(CategoryNotFound::class);
        $this->whenFindCategory();
    }

    /**
     * @throws Exception
     */
    public function testCreateTwoCategoriesWithSameNameReturnsException()
    {
        $this->givenAnExistentId();
        self::expectException(CategoryAlreadyExists::class);
        $this->whenCreateCategory();
    }

    /**
     * @throws Exception
     */
    public function testAExistingCategoryIdReturnsItsCategory()
    {
        $this->givenAnExistentId();
        $this->whenFindCategory();
        $this->thenCategoryIsSaved();
    }

    /**
     * @throws Exception
     */
    public function testUpdateANonExistentCategoryReturnsAlreadyExists()
    {
        $this->givenAnExistentId();
        self::expectException(CategoryAlreadyExists::class);
        $this->whenUpdateCategory();
    }

    private function givenAnInvalidNameOrDescription()
    {
        $this->name = 'Invalid name!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!';
        $this->description = 'Invalid name!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!';
        $this->repository = new InMemoryCategoryRepository([]);
    }

    /**
     * @throws Exception
     */
    private function whenCreateCategory()
    {
        $creator = new CategoryCreator($this->repository);
        $this->id = $creator->__invoke(new CategoryName($this->name), new CategoryDescription($this->description));
    }

    private function givenAValidCategory()
    {
        $this->name = 'Blonde beers';
        $this->description = 'Blonde beers are softer than brown ones';
        $this->repository = new InMemoryCategoryRepository([]);
    }

    private function thenCategoryIsSaved()
    {
        $finder = new CategoryFinder($this->repository);
        $cat = new Category($this->id, new CategoryName($this->name), new CategoryDescription($this->description));
        self::assertEquals($cat, $finder($this->id));
    }

    /**
     * @throws Exception
     */
    private function givenANonExistingCategory()
    {
        $this->id = CategoryId::generate();
        $this->repository = new InMemoryCategoryRepository([]);
    }

    private function whenFindCategory()
    {
        $finder = new CategoryFinder($this->repository);
        $this->category = $finder($this->id);
    }

    /**
     * @throws Exception
     */
    private function givenAnExistentId()
    {
        $this->repository = new InMemoryCategoryRepository([]);
        $this->name = 'test';
        $this->description = 'testing';
        $creator = new CategoryCreator($this->repository);
        $this->id = $creator(new CategoryName($this->name), new CategoryDescription($this->description));
    }

    private function whenUpdateCategory()
    {
        $updater = new CategoryUpdater($this->repository);
        $updater(new Category($this->id, new CategoryName($this->name), new CategoryDescription($this->description)));
    }

}
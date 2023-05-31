<?php

namespace Beer\Shopping\Test\Integration\Categories;

use BeerApi\Shopping\Categories\Application\CategoryCreator;
use BeerApi\Shopping\Categories\Application\CategoryFinder;
use BeerApi\Shopping\Categories\Domain\Category;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryDescription;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryId;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryName;
use BeerApi\Shopping\Connection\Connection;
use BeerApi\Shopping\DependencyServices\CategoriesProvider;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use PHPUnit\Framework\TestCase;

class CategoryRepositoryTest extends TestCase
{
    private CategoryName $name;
    private CategoryDescription $description;
    private CategoryId|null $categoryId;
    /**
     * @var CategoryCreator
     */
    private mixed $creator;
    private Container $container;
    private CategoryId $id;

    protected function setUp(): void
    {
        $db = Connection::access();
        // $db->query('delete from categories');
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    public function testCreateCategoryIsSaved()
    {
        $this->givenACategory();
        $this->whenCreateCategory();
        $this->thenCategoryIsSaved();
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    private function givenACategory()
    {
        $this->name = new CategoryName('Brewed beers');
        $this->description = new CategoryDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a dignissim turpis, ac molestie eros.');
        $this->categoryId = null;
        $cat = new CategoriesProvider(new Container());
        $this->container = $cat->register();
        /** @var CategoryCreator creator */
        $this->creator = $this->container->get(CategoryCreator::class);
    }

    /**
     * @throws Exception
     */
    private function whenCreateCategory()
    {
        $this->id = $this->creator->__invoke($this->name, $this->description, $this->categoryId);
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    private function thenCategoryIsSaved()
    {
        /** @var CategoryFinder $finder */
        $finder = $this->container->get(CategoryFinder::class);
        $cat = new Category($this->id, $this->name, $this->description, $this->categoryId);
        self::assertEquals($cat, $finder->__invoke($this->id));
    }
}
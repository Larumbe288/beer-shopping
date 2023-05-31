<?php

namespace BeerApi\Shopping\Categories\Infrastucture\Repositories;

use BeerApi\Shopping\Categories\Domain\Category;
use BeerApi\Shopping\Categories\Domain\Repositories\CategoryRepository;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryDescription;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryId;
use BeerApi\Shopping\Categories\Domain\ValueObject\CategoryName;
use BeerApi\Shopping\Connection\Doctrine;
use Doctrine\DBAL\Exception;
use PDOException;

/**
 *
 */
class MySQLCategoryRepository implements CategoryRepository
{

    /**
     * @throws Exception
     */
    public function insert(Category $category): void
    {
        $db = Doctrine::access();
        if (is_null($category->getSubId())) {

            $db->insert('categories')
                ->values(array(
                    "UUID" => ':uuid',
                    'name' => ':name',
                    'description' => ':description'
                ))
                ->setParameter(':uuid', $category->getCategoryId()->getValue())
                ->setParameter(':name', $category->getCategoryName()->getValue())
                ->setParameter(':description', $category->getCategoryDescription()->getValue())
                ->execute();
        } else {
            $db->insert('categories')
                ->values(array(
                    "UUID" => ':uuid',
                    'name' => ':name',
                    'description' => ':description',
                    'idCat' => ':idCat'
                ))
                ->setParameter(':uuid', $category->getCategoryId()->getValue())
                ->setParameter(':name', $category->getCategoryName()->getValue())
                ->setParameter(':description', $category->getCategoryDescription()->getValue())
                ->setParameter(':idCat', $category->getSubId()->getValue())
                ->execute();
        }
        $db = null;

    }

    /**
     * @throws Exception
     */
    public function update(Category $category)
    {
        $currentCategory = $this->findById($category->getCategoryId());
        $db = Doctrine::access();
        $db->update('categories')
            ->where('UUID = :id')->setParameter(':id', $category->getCategoryId()->getValue())
            ->set('name', ':name')->setParameter(':name', $category->getCategoryName()->getValue())
            ->set('description', ':description')->setParameter(':description', $category->getCategoryDescription()->getValue());
        if (!is_null($category->getSubId())) {
            $db->set('idCat', ':idCat')->setParameter(':idCat', $category->getSubId());
        } else {
            $db->set('idCat', 'null');
        }
        $db->execute();
        $db = null;
    }

    /**
     * @param CategoryId $categoryId
     * @return Category
     */
    public function findById(CategoryId $categoryId): Category
    {
        $db = Doctrine::access();
        $result = $db->select('*')->from('categories')->where('UUID = :id')->setParameter(':id', $categoryId->getValue())
            ->execute()->fetchAllAssociative();
        $db = null;
        return $this->mapToCategory($result)[0];
    }

    /**
     * @throws Exception
     */
    public function delete(CategoryId $categoryId)
    {
        $db = Doctrine::access();
        $id = $categoryId->getValue();
        $db->delete('categories')
            ->where('UUID = :id')->setParameter(':id', $id)->execute();
        $db = null;
    }

    /**
     * @throws Exception
     */
    public function getNumberCategories(): int
    {
        $db = Doctrine::access();
        $result = $db->select('count(UUID) as number')->from('categories')->execute()->fetchAllAssociative();
        return (int)$result[0]['number'];
    }

    /**
     * @param string $field
     * @param int $prev_offset
     * @param int $next_offset
     * @return Category[]
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function findAll(string $field, int $prev_offset, int $next_offset): array
    {
        $db = Doctrine::access();
        $db->select('*')->from('categories');
        $db->orderBy(":field", 'DESC')
            ->setParameter(':field', $field)
            ->setFirstResult($prev_offset)
            ->setMaxResults($next_offset);
        $result = $db->execute()->fetchAllAssociative();
        $db = null;
        return $this->mapToCategory($result);
    }

    /**
     * @param array $result
     * @return Category[]
     */
    private function mapToCategory(array $result): array
    {
        $arrayCategories = [];
        for ($i = 0; $i < count($result); $i++) {
            if (is_null($result[0]['idCat'])) {
                $arrayCategories[] = new Category(new CategoryId($result[$i]['UUID']), new CategoryName($result[$i]['name']), new CategoryDescription($result[$i]['description']),
                    null);
            } else {
                $arrayCategories[] = new Category(new CategoryId($result[$i]['UUID']), new CategoryName($result[$i]['name']), new CategoryDescription($result[$i]['description']),
                    new CategoryId($result[$i]['idCat']));
            }
        }
        return $arrayCategories;
    }
}
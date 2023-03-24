<?php

namespace BeerApi\Shopping\Categories\Infrastucture\Repositories;

use BeerApi\Shopping\Categories\Domain\Category;
use BeerApi\Shopping\Categories\Domain\Repositories\CategoryRepository;
use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryDescription;
use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryId;
use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryName;
use BeerApi\Shopping\Connection\Connection;
use PDOException;

/**
 *
 */
class MySQLCategoryRepository implements CategoryRepository
{

    public function insert(Category $category)
    {
        $db = Connection::access();
        try {
            $id = $category->getCategoryId()->getValue();
            $name = $category->getCategoryName()->getValue();
            $description = $category->getCategoryDescription()->getValue();
            if (is_null($category->getSubId())) {
                $sql = "insert into categories(UUID,name,description) VALUES ('$id','$name','$description')";
            } else {
                $subId = $category->getSubId()->getValue();
                $sql = "insert into categories(UUID,name,description,idCat) VALUES ('$id','$name','$description', $subId)";
            }
            $result = $db->query($sql);
            if (!$result) {
                echo $db->errorInfo();
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        finally {
            $db = null;
        }
    }

    public function update(Category $category)
    {
        $db = Connection::access();
        try {
            $category = $this->findById($category->getCategoryId());
            $id = $category->getCategoryId()->getValue();
            $name = $category->getCategoryName()->getValue();
            $description = $category->getCategoryDescription()->getValue();
            if (is_null($category->getSubId())) {
                $sql = "update categories set name='$name',description='$description' where UUID='$id'";

            } else {
                $subId = $category->getSubId()->getValue();
                $sql = "update categories set name='$name',description='$description',idCat='$subId' where UUID='$id'";
            }
            $result = $db->query($sql);
            if (!$result) {
                echo "Error: " . $db->errorInfo();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        finally {
            $db = null;
        }
    }

    /**
     * @param CategoryId $categoryId
     * @return Category
     */
    public function findById(CategoryId $categoryId): Category
    {
        $db = Connection::access();
        try {
            $id = $categoryId->getValue();
            $sql = "select UUID,name,description,idCat from categories where UUID='$id'";
            $result = $db->query($sql);
            $cat = $result->fetch();
            if ($cat) {
                if (is_null($cat['idCat'])) {
                    $category = new Category(new CategoryId($cat['UUID']), new CategoryName($cat['name']), new CategoryDescription($cat['description']));
                } else {
                    $category = new Category(new CategoryId($cat['UUID']), new CategoryName($cat['name']), new CategoryDescription($cat['description']),
                        new CategoryId($cat['idCat']));
                }
                return $category;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        finally {
            $db = null;
        }
    }

    public function delete(CategoryId $categoryId)
    {
        $db = Connection::access();
        try {
            $id = $categoryId->getValue();
            $sql = "delete from categories where UUID='$id'";
            $result = $db->query($sql);
            if (!$result) {
                echo "Error: " . $db->errorInfo();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        finally {
            $db = null;
        }
    }

    /**
     * @param string $field
     * @param int $prev_offset
     * @param int $next_offset
     * @return array|void
     */
    public function findAll(string $field, int $prev_offset, int $next_offset)
    {
        $categoryArray = [];
        $db = Connection::access();
        try {
            $sql = "select UUID,name,description,idCat from categories order by $field limit $prev_offset,$next_offset";
            $result = $db->query($sql);
            foreach ($result as $cat) {
                if (is_null($cat['idCat'])) {
                    $category = new Category(new CategoryId($cat['UUID']), new CategoryName($cat['name']), new CategoryDescription($cat['description']));
                } else {
                    $category = new Category(new CategoryId($cat['UUID']), new CategoryName($cat['name']), new CategoryDescription($cat['description']),
                        new CategoryId($cat['idCat']));
                }
                array_push($categoryArray, $category);
            }
            return $categoryArray;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        finally {
            $db = null;
        }
    }
}
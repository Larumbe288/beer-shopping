<?php

use BeerApi\Shopping\Categories\Application\CategoryCreator;
use BeerApi\Shopping\Categories\Domain\Category;
use BeerApi\Shopping\Categories\Infrastucture\Repositories\InMemoryCategoryRepository;

require __DIR__ . "/../../../vendor/autoload.php";

try {
    $repository = new InMemoryCategoryRepository([]);
    $cat = Category::randomCategory();
    $name = $cat->getCategoryName();
    $creator = new CategoryCreator($repository);
    $id = $creator($cat->getCategoryName(), $cat->getCategoryDescription());
    $memory = $repository->findAll();
    for ($i = 0; $i < count($memory); $i++) {
        foreach ($memory[$i] as $key => $value) {
            echo $key . " " . $value;
        }
    }
} catch (Exception $e) {
    exit(255);
}

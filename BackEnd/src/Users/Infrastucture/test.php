<?php
require __DIR__ . "/../../../../vendor/autoload.php";

use BeerApi\Shopping\Categories\Application\CategoryCreator;
use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryDescription;
use BeerApi\Shopping\Categories\Domain\ValueObjects\CategoryName;
use BeerApi\Shopping\Categories\Infrastucture\Repositories\InMemoryCategoryRepository;

$repo = new InMemoryCategoryRepository([]);
$creator = new CategoryCreator($repo);
$catName = CategoryName::randomName();
$catDescription = CategoryDescription::randomDescription();

try {
    $catId = $creator($catName, $catDescription);
    $memory = $repo->findAll();
    foreach ($memory as $key => $value) {
        echo $key . " " . $value->getCategoryName()->getValue();
    }
} catch (Exception $e) {
}
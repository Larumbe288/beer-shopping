<?php

namespace BeerApi\Shopping\Beers\Application;

use BeerApi\Shopping\Beers\Domain\Beer;
use BeerApi\Shopping\Beers\Domain\Repositories\BeerRepository;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerCategoryId;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerCity;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerCountry;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerDescription;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerId;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerLikes;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerManufacturingDate;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerName;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerPrice;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerVolume;

/**
 * Class BeerCreator
 * @package BeerApi\Shopping\Beers\Application
 */
class BeerCreator
{
    private BeerRepository $repository;

    public function __construct(BeerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(
        BeerName              $name,
        BeerDescription       $description,
        BeerCountry           $country,
        BeerCity              $city,
        BeerLikes             $likes,
        BeerCategoryId        $categoryId,
        BeerPrice             $price,
        BeerVolume            $volume,
        BeerManufacturingDate $date
    ): BeerId
    {
        $beer = Beer::create($name, $description, $country, $city, $likes, $categoryId, $price, $volume, $date);
        $this->repository->insert($beer);
        return $beer->getId();
    }
}
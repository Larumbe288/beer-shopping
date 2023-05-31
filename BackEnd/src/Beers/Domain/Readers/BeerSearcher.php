<?php

namespace BeerApi\Shopping\Beers\Domain\Readers;

use BeerApi\Shopping\Beers\Domain\Beer;

/**
 * Interface BeerSearcher
 * @package BeerApi\Shopping\Beers\Domain\Readers
 */
interface BeerSearcher
{
    /**
     * @param string $value
     * @return Beer[]
     */
    public function findBeerBySearch(string $value): array;

    public function findBeerInAPriceRange(int $min_value, int $max_value);

    public function findBeerByLikesOrMore(int $likes);

    public function findBeerByCategory(string $idCat);

    public function findBeerByDateOrBefore(string $date);

    public function findBeerInAVolumeRange(int $min_value, int $max_value);

    public function findBeersByCity(string $city);

    public function findBeersByCountry(string $country);
}
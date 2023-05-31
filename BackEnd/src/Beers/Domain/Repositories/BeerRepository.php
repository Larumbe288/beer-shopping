<?php

namespace BeerApi\Shopping\Beers\Domain\Repositories;

use BeerApi\Shopping\Beers\Application\DTOs\BeerDTO;
use BeerApi\Shopping\Beers\Domain\Beer;
use BeerApi\Shopping\Beers\Domain\ValueObject\BeerId;

/**
 * Interface BeerRepository
 * @package BeerApi\Shopping\Beers\Domain\Repositories
 */
interface BeerRepository
{
    public function insert(Beer $beer);

    public function find(BeerId $id): BeerDTO;

    public function findAll(string $field, int $prev_offset, int $next_offset);

    /**
     * @return Beer[]
     */
    public function findTenMostPopularBeers(): array;

    public function update(Beer $beer);

    public function delete(BeerId $beer);
}
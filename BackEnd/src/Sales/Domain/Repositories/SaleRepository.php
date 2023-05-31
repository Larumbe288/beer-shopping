<?php

namespace BeerApi\Shopping\Sales\Domain\Repositories;

use BeerApi\Shopping\Sales\Domain\Sale;
use BeerApi\Shopping\Sales\Domain\ValueObject\SaleId;
use BeerApi\Shopping\Users\Domain\ValueObject\UserId;

/**
 * Interface SaleRepository
 * @package BeerApi\Shopping\Sales\Domain\Repositories
 */
interface SaleRepository
{
    /**
     * @param Sale $sale
     * @return void
     */
    public function insert(Sale $sale): void;

    /**
     * @param SaleId $id
     * @return Sale
     */
    public function findById(SaleId $id): Sale;

    /**
     * @param UserId $id
     * @return Sale[]
     */
    public function findByUser(UserId $id): array;
}
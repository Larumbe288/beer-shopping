<?php

namespace BeerApi\Shopping\Sales\Application;

use BeerApi\Shopping\Sales\Domain\Repositories\SaleRepository;
use BeerApi\Shopping\Sales\Domain\Sale;
use BeerApi\Shopping\Sales\Domain\ValueObject\SaleId;

/**
 * Class SaleFinder
 * @package BeerApi\Shopping\Sales\Application
 */
class SaleFinder
{
    private SaleRepository $repository;

    public function __construct(SaleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param SaleId $id
     * @return Sale
     */
    public function __invoke(SaleId $id): Sale
    {
        return $this->repository->findById($id);
    }
}
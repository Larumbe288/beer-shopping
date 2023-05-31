<?php

namespace BeerApi\Shopping\Sales\Application;

use BeerApi\Shopping\Beers\Domain\Beer;
use BeerApi\Shopping\Sales\Domain\Repositories\SaleRepository;
use BeerApi\Shopping\Sales\Domain\Sale;
use BeerApi\Shopping\Sales\Domain\ValueObject\SaleDate;
use BeerApi\Shopping\Sales\Domain\ValueObject\SaleId;
use BeerApi\Shopping\Sales\Domain\ValueObject\SaleQuantity;
use BeerApi\Shopping\Sales\Domain\ValueObject\SaleStatus;
use BeerApi\Shopping\Users\Domain\User;
use Exception;

/**
 * Class SaleCreator
 * @package BeerApi\Shopping\Sales\Application
 */
class SaleCreator
{
    private SaleRepository $repository;

    public function __construct(SaleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param User $user
     * @param Beer $beer
     * @param SaleQuantity $quantity
     * @param SaleStatus $status
     * @param SaleDate $date
     * @return SaleId
     * @throws Exception
     */
    public function __invoke(User $user, Beer $beer, SaleQuantity $quantity, SaleStatus $status, SaleDate $date): SaleId
    {
        $sale = Sale::create($user, $beer, $quantity, $status, $date);
        $this->repository->insert($sale);
        return $sale->getId();
    }
}
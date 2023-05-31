<?php

namespace BeerApi\Shopping\Sales\Domain;

use BeerApi\Shopping\Beers\Domain\Beer;
use BeerApi\Shopping\Sales\Domain\ValueObject\SaleDate;
use BeerApi\Shopping\Sales\Domain\ValueObject\SaleId;
use BeerApi\Shopping\Sales\Domain\ValueObject\SaleQuantity;
use BeerApi\Shopping\Sales\Domain\ValueObject\SaleStatus;
use BeerApi\Shopping\Users\Domain\User;
use Exception;

/**
 * Class Sale
 * @package BeerApi\Shopping\Sales\Domain
 */
class Sale
{
    private User $user;
    private Beer $beer;
    private SaleId $id;
    private SaleQuantity $quantity;
    private SaleStatus $status;
    private SaleDate $date;

    public function __construct(User $user, Beer $beer, SaleId $id, SaleQuantity $quantity, SaleStatus $status, SaleDate $date)
    {
        $this->user = $user;
        $this->beer = $beer;
        $this->id = $id;
        $this->quantity = $quantity;
        $this->status = $status;
        $this->date = $date;
    }

    /**
     * @throws Exception
     */
    public static function create(User $user, Beer $beer, SaleQuantity $quantity, SaleStatus $status, SaleDate $date): self
    {
        return new self($user, $beer, SaleId::generate(), $quantity, $status, $date);
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Beer
     */
    public function getBeer(): Beer
    {
        return $this->beer;
    }

    /**
     * @return SaleId
     */
    public function getId(): SaleId
    {
        return $this->id;
    }

    /**
     * @return SaleQuantity
     */
    public function getQuantity(): SaleQuantity
    {
        return $this->quantity;
    }

    /**
     * @return SaleStatus
     */
    public function getStatus(): SaleStatus
    {
        return $this->status;
    }

    /**
     * @return SaleDate
     */
    public function getDate(): SaleDate
    {
        return $this->date;
    }


}
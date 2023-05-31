<?php

namespace BeerApi\Shopping\Sales\Domain\ValueObject;

use InvalidArgumentException;

/**
 * Class SaleStatus
 * @package BeerApi\Shopping\Sales\Domain\ValueObject
 */
class SaleStatus
{
    const VALID_STATUS = ["On demand", "Received", "Delivered"];
    private string $status;

    public function __construct(string $status)
    {
        if (!in_array($status, self::VALID_STATUS)) {
            throw new InvalidArgumentException();
        }
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->status;
    }
}
<?php

namespace BeerApi\Shopping\Sales\Domain\ValueObject;

use InvalidArgumentException;
use Ngcs\Core\ValueObjects\IntValue;

/**
 * Class SaleQuantity
 * @package BeerApi\Shopping\Sales\Domain\ValueObject
 */
class SaleQuantity extends IntValue
{
    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException();
        }
        parent::__construct($value);
    }
}
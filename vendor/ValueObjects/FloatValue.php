<?php
declare(strict_types=1);


namespace Ngcs\Core\ValueObjects;

/**
 * Class FloatValue
 * @package Ngcs\Core\ValueObjects
 */
abstract class FloatValue
{
    private float $value;

    /**
     * FloatValue constructor.
     * @param float $value
     */
    public function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }
}
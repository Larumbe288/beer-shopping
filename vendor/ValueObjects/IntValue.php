<?php
declare(strict_types=1);


namespace Ngcs\Core\ValueObjects;

/**
 * Class IntValue
 * @package Ngcs\Core\ValueObjects
 */
abstract class IntValue
{
    private int $value;

    /**
     * IntValue constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * isMultipleOf
     * @param int $divisor
     * @return bool
     */
    public function isMultipleOf(int $divisor): bool
    {
        return $this->value % $divisor === 0;
    }

    /**
     * isPositive
     * @return bool
     */
    public function isPositive(): bool
    {
        return $this->value > 0;
    }
}
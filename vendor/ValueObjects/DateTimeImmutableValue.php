<?php
declare(strict_types=1);


namespace Ngcs\Core\ValueObjects;

use DateTimeImmutable;

/**
 * Class DateTimeImmutableValue
 * @package Ngcs\Core\ValueObjects
 */
abstract class DateTimeImmutableValue
{
    private DateTimeImmutable $value;

    /**
     * DateTimeImmutableValue constructor.
     * @param DateTimeImmutable $value
     */
    public function __construct(DateTimeImmutable $value)
    {
        $this->value = $value;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getValue(): DateTimeImmutable
    {
        return $this->value;
    }
}
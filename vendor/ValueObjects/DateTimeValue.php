<?php
declare(strict_types=1);


namespace Ngcs\Core\ValueObjects;

use DateTime;
use DateTimeInterface;

/**
 * Class DateTimeValue
 * @package Ngcs\Core\ValueObjects
 */
abstract class DateTimeValue
{
    private DateTime $value;

    /**
     * DateTimeValue constructor.
     * @param DateTime $value
     */
    public function __construct(DateTime $value)
    {
        $this->value = clone $value;
    }

    /**
     * @return DateTime
     */
    public function getValue(): DateTime
    {
        return clone $this->value;
    }

    public function dateToString(): string
    {
        return $this->value->format(DateTimeInterface::RFC3339);
    }
}
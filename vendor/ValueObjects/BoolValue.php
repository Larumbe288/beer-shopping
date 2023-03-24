<?php

namespace Ngcs\Core\ValueObjects;

/**
 * BoolValue
 * @package Ngcs\Core\ValueObjects
 */
abstract class BoolValue
{
    private bool $value;

    /**
     * @param bool $value
     */
    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function getValue(): bool
    {
        return $this->value;
    }
}
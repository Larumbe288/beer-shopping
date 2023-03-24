<?php
declare(strict_types=1);

namespace Ngcs\Core\ValueObjects;

/**
 * Class EmailAddressValue
 * @package Ngcs\Core\ValueObjects
 */
abstract class EmailAddressValue
{
    private string $value;

    /**
     * @param string $value
     * @throws InvalidEmailAddress
     */
    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailAddress($value);
        }
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}

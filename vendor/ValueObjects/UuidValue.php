<?php
declare(strict_types=1);


namespace Ngcs\Core\ValueObjects;

use Exception;
use Ngcs\Core\Sec\UuidV4Generator;
use Ngcs\Core\Shared\Traits\UuidValidator;

/**
 * Class UuidValue
 * @package Ngcs\Core\ValueObjects
 */
abstract class UuidValue
{
    use UuidValidator;

    private string $value;

    /**
     * StringValue constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $value = mb_strtolower($value);

        if (!self::isValidUuid($value)) {
            throw new InvalidUuid($value);
        }

        $this->value = $value;
    }

    /**
     * @return static
     * @throws Exception
     */
    public static function generate(): self
    {
        return new static(UuidV4Generator::generateUuid());
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
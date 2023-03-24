<?php
declare(strict_types=1);


namespace Ngcs\Core\ValueObjects;

use InvalidArgumentException;
use Throwable;

/**
 * Class InvalidUuid
 * @package Ngcs\Core\ValueObjects
 */
final class InvalidUuid extends InvalidArgumentException
{

    /**
     * InvalidUuid constructor.
     * @param string $uuid
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $uuid, $code = 0, Throwable $previous = null)
    {
        parent::__construct("Invalid uuid $uuid", $code, $previous);
    }
}
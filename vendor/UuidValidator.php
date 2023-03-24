<?php

namespace Ngcs\Core\Shared\Traits;

/**
 * Trait UuidValidator
 */
trait UuidValidator
{
    public static final function isValidUuid(string ...$value): bool
    {
        foreach ($value as $v) {
            if (preg_match('~^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$~i', $v) === 0) {
                return false;
            }
        }

        return true;
    }
}
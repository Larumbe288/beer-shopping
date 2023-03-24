<?php
declare(strict_types=1);


namespace Ngcs\Core\Sec\Crypt;

/**
 * Class BcryptPasswordHash
 * @package Ngcs\Core\Sec\Crypt
 */
final class BcryptPasswordHash
{
    public const ROUNDS = 10;

    public function hash(string $password, string $pepper = ''): string
    {
        $options = [
            'cost' => self::ROUNDS,
        ];
        return password_hash($password . $pepper, PASSWORD_BCRYPT, $options);
    }

    public function verify(string $hash, string $password, string $pepper = ''): bool
    {
        return password_verify($password . $pepper, $hash);
    }
}
<?php

namespace BeerShopping\App\Models\Users\Domain\ValueObject;

class UserId
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->id;
    }
}
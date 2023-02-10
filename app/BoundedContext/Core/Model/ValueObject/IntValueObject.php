<?php

namespace App\BoundedContext\Core\Model\ValueObject;

class IntValueObject
{
    protected $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getInt(): int
    {
        return $this->value;
    }
}

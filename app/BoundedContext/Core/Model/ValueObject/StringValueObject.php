<?php

namespace App\BoundedContext\Core\Model\ValueObject;

class StringValueObject
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getString(): string
    {
        return $this->value;
    }
}

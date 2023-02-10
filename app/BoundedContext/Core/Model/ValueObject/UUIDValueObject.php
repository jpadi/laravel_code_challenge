<?php

namespace App\BoundedContext\Core\Model\ValueObject;


use App\BoundedContext\Core\Model\Exceptions\InvalidUUIDException;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

/**
 * UUID value object. Necesary to validate that uuid are correct
 * NOTE: This value object is in the model layer but we implement it with lavarale Str::UUID this violation is necesary
 * just for avoid implement uuid but anyway is only here and all uuid should use this class so in a future it can be
 * implemented here and use all domain driving desing rules
 */
class UUIDValueObject
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     * @throws InvalidUUIDException
     */
    public function __construct(string $value)
    {
        if (!Uuid::isValid($value)) {
            throw new InvalidUUIDException("bad uuid: " . $value);
        }
        $this->value = $value;
    }

    /**
     * @return UUIDValueObject
     * @throws InvalidUUIDException
     */
    public static function generate()
    {
        return new UUIDValueObject(Str::uuid());
    }

    /**
     * @return string
     */
    public function getString(): string
    {
        return $this->value;
    }
}

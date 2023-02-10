<?php

namespace App\BoundedContext\Core\Model\ValueObject;

use Carbon\Exceptions\InvalidDateException;

class DateTimeValueObject
{
    /**
     * @var \DateTime
     */
    private $value;

    public function __construct(?\DateTime $value)
    {
        $this->value = $value;
    }

    /**
     * @param string $date
     * @return void
     */
    public static function fromString(?string $dateString)
    {
        try {
            $dateTime = $dateString ? new \DateTime($dateString) : null;
            return new DateTimeValueObject($dateTime);
        } catch (\Exception $e) {
            throw new InvalidDateException("cant convert \"" . $dateString . "\"" . " to date time");
        }

    }

    public function getDateTime(): ?\DateTime
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function toISO8601()
    {
        return $this->value->format(\DateTime::ISO8601);
    }
}

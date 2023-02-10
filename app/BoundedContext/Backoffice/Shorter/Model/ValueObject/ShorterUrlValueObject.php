<?php

namespace App\BoundedContext\Backoffice\Shorter\Model\ValueObject;

use App\BoundedContext\Backoffice\Shorter\Model\Exception\InvalidShorterUrlException;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\Validator\UrlValidator;

class ShorterUrlValueObject
{

    use UrlValidator;

    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
        $this->validate();
    }

    /**
     * @return void
     * @throws InvalidShorterUrlException
     */
    private function validate(): void {
        if (!$this->validateUrl($this->value)) {
            throw new InvalidShorterUrlException($this->value);
        }
    }

    /**
     * @return string
     */
    public function getString(): string
    {
        return $this->value;
    }


}

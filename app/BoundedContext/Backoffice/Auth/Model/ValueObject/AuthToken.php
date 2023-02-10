<?php

namespace App\BoundedContext\Backoffice\Auth\Model\ValueObject;

use App\BoundedContext\Backoffice\Auth\Model\Exception\InvalidAuthToken;

class AuthToken
{

    const STATE_INVALID = -1;
    const STATE_CURLY_BRACKET = 1;
    const STATE_SQUARE_BRACKET = 2;
    const STATE_PARENTHESIS = 3;
    const STATE_CLOSE = 4;


    const CHARACTER_MAP = [
        "{" => "}",
        "[" => "]",
        "(" => ")",
    ];

    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     * @throws InvalidAuthToken
     */
    public function __construct(string $value)
    {
        $this->value = $value;
        if (!$this->validate()) {
            throw new InvalidAuthToken($value);
        }
    }

    /**
     * @param string $value
     * @return AuthToken
     * @throws InvalidAuthToken
     */
    public static function create(string $value): AuthToken
    {
        return new AuthToken($value);
    }

    /**
     *
     * @return bool
     */
    private function validate(): bool
    {

        $len = strlen($this->value);

        if ($len === 0) {
            return false;
        }

        // as every init character " {[({" need to have a close character "}])" the length should be even number
        if ($len % 2 != 0) {
            return false;
        }

        $stack = [];

        for ($i = 0; $i < $len; $i++) {
            $char = $this->value[$i];
            $state = $this->getState($char);

            if ($state  === self::STATE_INVALID) {
                return false;
            }

            if ($state === self::STATE_CLOSE) {
                $stackChar = array_shift($stack);
                if (!$this->compareCloseCharacter($stackChar, $char)) {
                    return false;
                }
            } else {
                array_unshift($stack, $char);
            }

        }


        return empty($stack);
    }

    private function compareCloseCharacter($openChar, $closeChar) {
        if (self::CHARACTER_MAP[$openChar] !== $closeChar) {
            return false;
        }
        return true;
    }

    private function getState($char): int
    {

        switch ($char) {
            case "{":
                return self::STATE_CURLY_BRACKET;
            case "[":
                return self::STATE_SQUARE_BRACKET;
            case "(":
                return self::STATE_PARENTHESIS;
            case "}":
            case "]":
            case ")":
                return self::STATE_CLOSE;
            default:
        }

        return self::STATE_INVALID;
    }

    public function getString(): string
    {
        return $this->value;
    }

}

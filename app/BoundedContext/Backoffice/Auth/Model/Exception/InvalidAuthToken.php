<?php

namespace App\BoundedContext\Backoffice\Auth\Model\Exception;

class InvalidAuthToken extends \Exception
{

    /**
     * @var string
     */
    private $token;

    /**
     * @param $token
     */
    public function __construct(string $token)
    {
        parent::__construct("Invalid token \"{$token}\"");
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }


}

<?php

namespace App\BoundedContext\Backoffice\Auth\Application\Query;

use App\BoundedContext\Core\Model\QueryBus\Query;

class CheckAuthTokenQuery implements Query
{
    /**
     * @var string
     */
    private $token;

    /**
     * @param string $token
     */
    public function __construct(string $token)
    {
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

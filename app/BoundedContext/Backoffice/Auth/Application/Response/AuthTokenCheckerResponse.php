<?php

namespace App\BoundedContext\Backoffice\Auth\Application\Response;

use App\BoundedContext\Core\Model\QueryBus\Response;

class AuthTokenCheckerResponse implements Response
{
    /**
     * @var bool
     */
    private $valid;

    /**
     * @param bool $valid
     */
    public function __construct(bool $valid)
    {
        $this->valid = $valid;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }


    public function toArray(): array
    {
        return [
            "valid" => $this->valid
        ];
    }
}

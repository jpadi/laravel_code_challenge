<?php

namespace App\BoundedContext\Backoffice\Shorter\Application\Query;

use App\BoundedContext\Core\Model\QueryBus\Query;

class GetShorterUrlQuery implements Query
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }


}

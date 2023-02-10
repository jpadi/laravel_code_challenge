<?php

namespace App\BoundedContext\Core\Model\QueryBus;

interface Response
{
    /**
     * @return array
     */
    public function toArray(): array;
}

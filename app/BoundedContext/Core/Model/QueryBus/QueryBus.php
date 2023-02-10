<?php

namespace App\BoundedContext\Core\Model\QueryBus;

interface QueryBus
{
    public function query(Query $query): ?Response;
}

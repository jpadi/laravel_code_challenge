<?php

namespace App\BoundedContext\Core\Infra\QueryBus\SimpleInMemory;

use App\BoundedContext\Core\Model\Exceptions\QueryHandlerNotFound;
use App\BoundedContext\Core\Model\QueryBus\Query;
use App\BoundedContext\Core\Model\QueryBus\QueryBus;
use App\BoundedContext\Core\Model\QueryBus\Response;

class SimpleInMemoryQueryBus implements QueryBus
{

    /**
     * @var array
     */
    private $queryHandlers = [];

    public function addHandler(string $queryName, callable $queryHandler)
    {
        $this->queryHandlers[$queryName] = $queryHandler;
    }

    /**
     * @param Query $query
     * @return Response|null
     * @throws QueryHandlerNotFound
     */
    public function query(Query $query): ?Response
    {
        $queryHandler = $this->queryHandlers[get_class($query)] ?? null;
        if ($queryHandler === null) {
            throw new QueryHandlerNotFound($query);
        }
        return call_user_func($queryHandler, $query);
    }
}

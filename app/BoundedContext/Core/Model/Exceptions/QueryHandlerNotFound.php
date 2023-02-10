<?php

namespace App\BoundedContext\Core\Model\Exceptions;

use App\BoundedContext\Core\Model\QueryBus\Query;

class QueryHandlerNotFound extends \Exception
{
    /**
     * @var Query
     */
    private $query;

    public function __construct(Query $query)
    {
        parent::__construct("No query handler found for \"" . get_class($query) . "\"");
        $this->query = $query;
    }
}

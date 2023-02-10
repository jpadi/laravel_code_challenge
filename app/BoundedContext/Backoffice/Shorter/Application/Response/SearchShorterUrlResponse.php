<?php

namespace App\BoundedContext\Backoffice\Shorter\Application\Response;

use App\BoundedContext\Core\Model\Responses\ListResponse;

class SearchShorterUrlResponse extends ListResponse
{

    /**
     * @param SearchShorterUrlItemResponse[] $data
     * @param int $offset
     * @param int $limit
     * @param int $total
     */
    public function __construct(array $data, int $offset, int $limit, int $total)
    {
        parent::__construct($data, $offset, $limit, $total);
    }
}

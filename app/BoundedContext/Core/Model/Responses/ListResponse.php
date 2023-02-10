<?php

namespace App\BoundedContext\Core\Model\Responses;

use App\BoundedContext\Core\Model\QueryBus\Response;

class ListResponse implements Response
{

    /**
     * @var ListItemResponse[]
     */
    private $data;

    /**
     * @var int
     */
    private $offset = 0;

    /**
     * @var int
     */
    private $limit = 0;

    /**
     * @var int
     */
    private $total = 0;

    /**
     * @param ListItemResponse[] $data
     * @param int $offset
     * @param int $limit
     * @param int $total
     */
    public function __construct(array $data, int $offset, int $limit, int $total)
    {
        $this->data = $data;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->total = $total;
    }

    /**
     * @return ListItemResponse[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return array
     */
    public function toArray(): array {
        $data = [];

        foreach($this->data as $item) {
            $data[] = $item->toArray();
        }

        return [
            "data" => $data,
            "offset" => $this->offset,
            "limit" => $this->limit,
            "total" => $this->total
        ];
    }


}

<?php

namespace App\BoundedContext\Backoffice\Shorter\Application\Request;

class SearchShorterUrlRequest
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $orderBy;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var int
     */
    private $limit;

    /**
     * @param string $text
     * @param string $orderBy
     * @param int $offset
     * @param int $limit
     */
    public function __construct(string $text, string $orderBy,int $offset, int $limit)
    {
        $this->text = $text;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->orderBy = $orderBy;

    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
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


}

<?php

namespace App\BoundedContext\Backoffice\Shorter\Model\Criteria;

use App\BoundedContext\Backoffice\Shorter\Model\Exception\InvalidSearchShorterUrlCriteriaOrderBy;

class SearchShorterUrlCriteria
{
    const ORDER_BY_MAP = [
        "urlAsc" => true,
        "urlDesc" => true,
    ];

    const ORDER_BY_NONE = "";
    const ORDER_BY_URL_ASC = "urlAsc";
    const ORDER_BY_URL_DESC = "urlDesc";

    /**
     * @var string
     */
    private $text;

    /**
     * @var bool
     */
    private $orderByUrlAsc = false;

    /**
     * @var bool
     */
    private $orderByUrlDesc = false;

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
     * @throws InvalidSearchShorterUrlCriteriaOrderBy
     */
    public function __construct(string $text, string $orderBy,int $offset, int $limit)
    {
        $this->text = $text;
        $this->offset = $offset;
        $this->limit = $limit;

        $this->setOrderBy($orderBy);
    }

    /**
     * @param $orderBy
     * @return void
     * @throws InvalidSearchShorterUrlCriteriaOrderBy
     */
    private function setOrderBy($orderBy) {
        if ($orderBy !== "") {
            if (!isset(self::ORDER_BY_MAP[$orderBy])) {
                throw new InvalidSearchShorterUrlCriteriaOrderBy($orderBy);
            }

            switch ($orderBy) {
                case "urlAsc":
                    $this->orderByUrlAsc = true;
                case "urlDesc":
                    $this->orderByUrlDesc = true;
            }
        }
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return bool
     */
    public function isOrderByUrlAsc(): bool
    {
        return $this->orderByUrlAsc;
    }

    /**
     * @return bool
     */
    public function isOrderByUrlDesc(): bool
    {
        return $this->orderByUrlDesc;
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

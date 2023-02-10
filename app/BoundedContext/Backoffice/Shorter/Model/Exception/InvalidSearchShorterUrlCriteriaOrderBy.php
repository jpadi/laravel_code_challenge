<?php

namespace App\BoundedContext\Backoffice\Shorter\Model\Exception;

class InvalidSearchShorterUrlCriteriaOrderBy extends \Exception
{

    private $orderBy;

    /**
     * @param $orderBy
     */
    public function __construct($orderBy)
    {
        parent::__construct("Invalid order by \"". $orderBy ."\"");
        $this->orderBy = $orderBy;
    }

    /**
     * @return mixed
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }


}

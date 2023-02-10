<?php

namespace App\BoundedContext\Backoffice\Shorter\Model\Exception;

class InvalidShorterUrlException extends \Exception
{

    /**
     * @var string
     */
    private $url;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        parent::__construct("Invalid url \"". $url ."\"");
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

}

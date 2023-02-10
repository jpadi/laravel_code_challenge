<?php

namespace App\BoundedContext\Backoffice\Shorter\Model\Exception;

class InvalidShorterUrlShortException extends \Exception
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
        parent::__construct("Invalid short url \"". $url ."\"");
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

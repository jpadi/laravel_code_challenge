<?php

namespace App\BoundedContext\Backoffice\Shorter\Application\Request;

class CreateShorterUrlCreatorRequest
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $url;

    /**
     * @param string $id
     * @param string $url
     */
    public function __construct(string $id, string $url)
    {
        $this->id = $id;
        $this->url = $url;
    }


    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }


}

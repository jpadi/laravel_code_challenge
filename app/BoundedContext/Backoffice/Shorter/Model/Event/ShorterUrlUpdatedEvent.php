<?php

namespace App\BoundedContext\Backoffice\Shorter\Model\Event;

use App\BoundedContext\Core\Model\EventBus\Event;
use App\BoundedContext\Core\Model\ValueObject\UUIDValueObject;

class ShorterUrlUpdatedEvent extends Event
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $shortUrl;

    /**
     * @var int
     */
    private $version;

    /**
     * @param string $id
     * @param string $url
     * @param string $shorUrl
     * @throws \App\BoundedContext\Core\Model\Exceptions\EventAttributeNotFound
     * @throws \App\BoundedContext\Core\Model\Exceptions\InvalidUUIDException
     */
    public function __construct(string $id, string $url, string $shorUrl, int $version)
    {
        parent::__construct($id, UUIDValueObject::generate()->getString(), ["id", "url", "shortUrl", "version"]);

        $this->id = $id;
        $this->url = $url;
        $this->shortUrl = $shorUrl;
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getShortUrl(): string
    {
        return $this->shortUrl;
    }

    /**
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }


}

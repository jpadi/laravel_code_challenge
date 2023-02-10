<?php

namespace App\BoundedContext\Backoffice\Shorter\Model\Entity;

use App\BoundedContext\Backoffice\Shorter\Model\Event\ShorterUrlCreatedEvent;
use App\BoundedContext\Backoffice\Shorter\Model\Event\ShorterUrlUpdatedEvent;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterShortUrlValueObject;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterUrlValueObject;
use App\BoundedContext\Core\Model\Aggregates\AggregateRoot;
use App\BoundedContext\Core\Model\ValueObject\IntValueObject;
use App\BoundedContext\Core\Model\ValueObject\UUIDValueObject;

class ShorterUrl extends AggregateRoot
{

    /**
     * @var UUIDValueObject
     */
    private $id;
    /**
     * @var ShorterUrlValueObject
     */
    private $url;

    /**
     * @var ShorterShortUrlValueObject
     */
    private $shortUrl;

    /**
     * @var IntValueObject
     */
    private $version;

    /**
     * @param UUIDValueObject $id
     * @param ShorterUrlValueObject $url
     * @param ShorterShortUrlValueObject $shortUrl
     */
    public function __construct(UUIDValueObject $id, ShorterUrlValueObject $url, ShorterShortUrlValueObject $shortUrl, IntValueObject $version)
    {
        $this->id = $id;
        $this->url = $url;
        $this->shortUrl = $shortUrl;
        $this->version = $version;
    }

    /**
     * @param UUIDValueObject $id
     * @param ShorterUrlValueObject $url
     * @param ShorterShortUrlValueObject $shortUrl
     * @return ShorterUrl
     * @throws \App\BoundedContext\Core\Model\Exceptions\EventAttributeNotFound
     * @throws \App\BoundedContext\Core\Model\Exceptions\InvalidUUIDException
     */
    public static function create(UUIDValueObject $id, ShorterUrlValueObject $url, ShorterShortUrlValueObject $shortUrl) :ShorterUrl {

        $version = new IntValueObject(1);
        $entity = new ShorterUrl($id, $url, $shortUrl, $version);
        $event = new ShorterUrlCreatedEvent(
            $id->getString(),
            $url->getString(),
            $shortUrl->getString(),
            $version->getInt()
        );
        $entity->addEvent($event);
        return $entity;
    }

    /**
     * @param ShorterUrlValueObject $url
     * @param ShorterShortUrlValueObject $shortUrl
     * @param IntValueObject $version
     * @return void
     * @throws \App\BoundedContext\Core\Model\Exceptions\EventAttributeNotFound
     * @throws \App\BoundedContext\Core\Model\Exceptions\InvalidUUIDException
     */
    public function update(ShorterUrlValueObject $url, ShorterShortUrlValueObject $shortUrl, IntValueObject $version) {
        $this->url = $url;
        $this->shortUrl = $shortUrl;
        $this->version = $version;

        $event = new ShorterUrlUpdatedEvent(
            $this->id->getString(),
            $this->url->getString(),
            $this->shortUrl->getString(),
            $this->version->getInt()
        );


        $this->addEvent($event);
    }

    /**
     * @return UUIDValueObject
     */
    public function getId(): UUIDValueObject
    {
        return $this->id;
    }

    /**
     * @return ShorterUrl
     */
    public function getUrl(): ShorterUrlValueObject
    {
        return $this->url;
    }

    /**
     * @return ShorterShortUrlValueObject
     */
    public function getShortUrl(): ShorterShortUrlValueObject
    {
        return $this->shortUrl;
    }

    /**
     * @return IntValueObject
     */
    public function getVersion(): IntValueObject
    {
        return $this->version;
    }

    public function toArray() : array {
        return [
            "id" => $this->id->getString(),
            "url" => $this->url->getString(),
            "shortUrl" => $this->shortUrl->getString(),
            "version" => $this->version->getInt()
        ];
    }

    public function toArraySnakeCase() : array {
        return [
            "id" => $this->id->getString(),
            "url" => $this->url->getString(),
            "short_url" => $this->shortUrl->getString(),
            "version" => $this->version->getInt()
        ];
    }

}

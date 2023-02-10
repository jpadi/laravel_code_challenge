<?php

namespace App\BoundedContext\Backoffice\Shorter\Model\Entity;

use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterShortUrlValueObject;
use App\BoundedContext\Core\Model\Aggregates\AggregateRoot;

class ShorterShortUrl extends AggregateRoot
{

    /**
     * @var ShorterShortUrlValueObject
     */
    private $shortUrl;

    /**
     * @param ShorterShortUrlValueObject $shortUrl
     */
    public function __construct(ShorterShortUrlValueObject $shortUrl)
    {
        $this->shortUrl = $shortUrl;
    }

    /**
     * @return ShorterShortUrlValueObject
     */
    public function getShortUrl(): ShorterShortUrlValueObject
    {
        return $this->shortUrl;
    }


}

<?php

namespace App\BoundedContext\Backoffice\Shorter\Model\Repository;

use App\BoundedContext\Backoffice\Shorter\Model\Entity\ShorterShortUrl;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterUrlValueObject;
use App\BoundedContext\Core\Model\Exceptions\EntityNotFound;

interface ShorterShortUrlRepository
{

    /**
     * @param ShorterUrlValueObject $url
     * @return ShorterShortUrl
     * @throws EntityNotFound
     */
    public function findByUrl(ShorterUrlValueObject $url) : ShorterShortUrl;

}

<?php

namespace App\BoundedContext\Backoffice\Shorter\Model\Repository;

use App\BoundedContext\Backoffice\Shorter\Model\Criteria\SearchShorterUrlCriteria;
use App\BoundedContext\Backoffice\Shorter\Model\Entity\ShorterUrl;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterUrlValueObject;
use App\BoundedContext\Core\Model\Exceptions\EntityNotFound;
use App\BoundedContext\Core\Model\ValueObject\UUIDValueObject;

interface ShorterUrlRepository
{

    /**
     *
     * @return ShorterUrl
     * @throws EntityNotFound By convencion if a method name find.. should find something if not it throws exception. If the name is search.. it not throw exceptions
     */
    public function findById(UUIDValueObject $id) : ShorterUrl;

    /**
     * @param ShorterUrlValueObject $url
     * @return ShorterUrl
     */
    public function searchByUrl(ShorterUrlValueObject $url) : ?ShorterUrl;

    /**
     * @param SearchShorterUrlCriteria $criteria
     * @return int
     */
    public function count(SearchShorterUrlCriteria $criteria): int;

    /**
     * @return ShorterUrl[]
     */
    public function search(SearchShorterUrlCriteria $criteria): array;

    /**
     * @param ShorterUrl $urlEntity
     * @return void
     */
    public function create(ShorterUrl $urlEntity): void;

    /**
     * @param ShorterUrl $url
     * @return void
     */
    public function update(ShorterUrl $url): void;
}

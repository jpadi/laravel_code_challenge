<?php

namespace App\BoundedContext\Backoffice\Shorter\Infra\Repository\Eloquent;

use App\BoundedContext\Backoffice\Shorter\Model\Criteria\SearchShorterUrlCriteria;
use App\BoundedContext\Backoffice\Shorter\Model\Entity\ShorterUrl;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterShortUrlValueObject;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterUrlValueObject;
use App\BoundedContext\Core\Model\Exceptions\EntityNotFound;
use App\BoundedContext\Core\Model\Exceptions\OptimisticLockException;
use App\BoundedContext\Core\Model\ValueObject\IntValueObject;
use App\BoundedContext\Core\Model\ValueObject\UUIDValueObject;
use Illuminate\Support\Facades\DB;
use App\BoundedContext\Backoffice\Shorter\Model\Repository\ShorterUrlRepository;
use App\BoundedContext\Core\Model\Exceptions\InvalidUUIDException;
use Illuminate\Database\Query\Builder;

class ShorterUrlEloquentRepository implements ShorterUrlRepository
{

    const TABLE = "shorter_url";

    /**
     * with database data create an entity
     * @param $data
     * @return ShorterUrl
     * @throws InvalidUUIDException
     */
    private function createEntity($data): ShorterUrl {
        return new ShorterUrl(
            new UUIDValueObject($data->id),
            new ShorterUrlValueObject($data->url),
            new ShorterShortUrlValueObject($data->short_url),
            new IntValueObject($data->version)
        );
    }

    /**
     * @param UUIDValueObject $id
     * @return ShorterUrl
     * @throws EntityNotFound
     * @throws InvalidUUIDException
     */
    public function findById(UUIDValueObject $id) : ShorterUrl
    {
        $data = DB::table(self::TABLE)
            ->where("id", $id->getString())
            ->first();

        if (!$data) {
            throw new EntityNotFound(self::TABLE, $id->getString());
        }

        return $this->createEntity($data);
    }

    /**
     * @param ShorterUrlValueObject $url
     * @return ShorterUrl|null
     * @throws InvalidUUIDException
     */
    public function searchByUrl(ShorterUrlValueObject $url) : ?ShorterUrl{
        $data = DB::table(self::TABLE)
            ->where("url", $url->getString())
            ->first();

        if (!$data) {
            return null;
        }

        return $this->createEntity($data);
    }


    /**
     * @param SearchShorterUrlCriteria $query
     * @return Builder
     */
    private function searchUrlQueryBuilder(SearchShorterUrlCriteria $query): Builder
    {
        $queryBuilder = DB::table(self::TABLE);

        if ($query->getText()) {
            $queryBuilder->where("url", "like", "%" .$query->getText() . "%", "or");
            $queryBuilder->where("short_url", "like", "%" .$query->getText() . "%", "or");
        }

        if ($query->isOrderByUrlAsc()) {
            $queryBuilder->orderBy("url");
        } else if ($query->isOrderByUrlDesc()) {
            $queryBuilder->orderBy("url" , "desc");
        }

        return $queryBuilder;
    }

    /**
     * @param SearchShorterUrlCriteria $query
     * @return int
     */
    public function count(SearchShorterUrlCriteria $query): int
    {
        $queryBuilder = $this->searchUrlQueryBuilder($query);

        return $queryBuilder->count();
    }

    /**
     * @param SearchShorterUrlCriteria $criteria
     * @return array|ShorterUrl[]
     * @throws InvalidUUIDException
     */
    public function search(SearchShorterUrlCriteria $criteria): array
    {
        $queryBuilder = $this->searchUrlQueryBuilder($criteria)
            ->offset($criteria->getOffset())
            ->limit($criteria->getLimit());

        $result = [];
        foreach ($queryBuilder->get() as $item) {

            $url = $this->createEntity($item);
            $result[] = $url;
        }

        return $result;
    }


    public function create(ShorterUrl $urlEntity): void
    {
        $data = [$urlEntity->toArraySnakeCase()];
        DB::table(self::TABLE)->insert($data);
    }

    /**
     * @param ShorterUrl $url
     * @return void
     * @throws OptimisticLockException
     */
     public function update(ShorterUrl $url): void {

        $version = $url->getVersion()->getInt() - 1;

        $data = $url->toArraySnakeCase();

        // for increment the current version in the database in atomic way
        $data["version"] = DB::raw("version + 1");

        $result = DB::table(self::TABLE)
            ->where("id", $data['id'])
            ->where("version", $version)
            ->update($data);

        if ($result === 0) {
            throw new OptimisticLockException("error writing on table \"" . self::TABLE . "\" because version");
        }
     }


}

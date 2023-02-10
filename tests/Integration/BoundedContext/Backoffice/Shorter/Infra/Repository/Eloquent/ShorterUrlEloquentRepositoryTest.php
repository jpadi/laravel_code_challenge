<?php

namespace Tests\Integration\BoundedContext\Backoffice\Shorter\Infra\Repository\Eloquent;

use App\BoundedContext\Backoffice\Shorter\Infra\Repository\Eloquent\ShorterUrlEloquentRepository;
use App\BoundedContext\Backoffice\Shorter\Model\Criteria\SearchShorterUrlCriteria;
use App\BoundedContext\Backoffice\Shorter\Model\Entity\ShorterUrl;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterShortUrlValueObject;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterUrlValueObject;
use App\BoundedContext\Core\Model\ValueObject\IntValueObject;
use App\BoundedContext\Core\Model\ValueObject\UUIDValueObject;
use Illuminate\Support\Facades\DB;
use Tests\IntegrationTestCase;

class ShorterUrlEloquentRepositoryTest extends IntegrationTestCase
{

    const TOTAL_URLS = 1;

    const SEARCH_STRING = "google";
    const SEARCH_OFFSET = 0;
    const SEARCH_LIMIT = 50;
    const SEARCH_ORDER_BY_NAME = true;

    const FIND_ID = "fe0c8e3e-a7f0-11ed-afa1-0242ac120002";
    const FIND_URL = "https://google.com";
    const FIND_URL_SHORT = "https://google.com";
    const FIND_VERSION = 1;

    const INSERT_ID = "ea200b22-a7ef-11ed-afa1-0242ac120002";
    const INSERT_URL = "https://yahoo.es";
    const INSERT_URL_SHORT = "https://yahoo.es";
    const INSERT_VERSION = 1;

    const UPDATE_ID = "fe0c8e3e-a7f0-11ed-afa1-0242ac120002";
    const UPDATE_URL = "https://yahoo.es";
    const UPDATE_URL_SHORT = "https://yahoo.es";
    const UPDATE_VERSION = 2;

    public function setUp(): void
    {
        parent::setUp();

        $urls = [
            [
                "id" => self::FIND_ID,
                "url" => self::FIND_URL,
                "short_url" => self::FIND_URL_SHORT,
                "version" => self::FIND_VERSION
            ],
        ];

        DB::table("shorter_url")->insert($urls);
    }

    /**
     * @return void
     */
    public function testFindById()
    {
        $id = new UUIDValueObject(self::FIND_ID);
        $repository = new ShorterUrlEloquentRepository();
        $response = $repository->findById($id);
        $expected = [
            "id" => self::FIND_ID,
            "url" => self::FIND_URL,
            "shortUrl" => self::FIND_URL_SHORT,
            "version" => self::FIND_VERSION
        ];
        $this->assertEquals($expected, $response->toArray());
    }

       /**
     * @return void
     */
    public function testsearchByUrl()
    {
        $url = new ShorterUrlValueObject(self::FIND_URL);
        $repository = new ShorterUrlEloquentRepository();
        $response = $repository->searchByUrl($url);
        $expected = [
            "id" => self::FIND_ID,
            "url" => self::FIND_URL,
            "shortUrl" => self::FIND_URL_SHORT,
            "version" => self::FIND_VERSION
        ];
        $this->assertEquals($expected, $response->toArray());
    }


    /**
     * @return void
     */
    public function testCount()
    {
        $query = new SearchShorterUrlCriteria(
            self::SEARCH_STRING, SearchShorterUrlCriteria::ORDER_BY_NONE ,self::SEARCH_OFFSET, self::SEARCH_LIMIT
        );
        $repository = new ShorterUrlEloquentRepository();
        $response = $repository->count($query);

        $this->assertEquals(self::TOTAL_URLS, $response);
    }

    /**
     *
     * @return void
     */
    public function testSearch()
    {
        $query = new SearchShorterUrlCriteria(
            self::SEARCH_STRING, SearchShorterUrlCriteria::ORDER_BY_NONE ,self::SEARCH_OFFSET, self::SEARCH_LIMIT
        );
        $repository = new ShorterUrlEloquentRepository();
        $response = $repository->search($query);

        $expected = [
            new ShorterUrl(
                new UUIDValueObject(self::FIND_ID),
                new ShorterUrlValueObject(self::FIND_URL),
                new ShorterShortUrlValueObject(self::FIND_URL_SHORT),
                new IntValueObject(self::FIND_VERSION)
            )
        ];

        $this->assertEquals($expected, $response);
    }

    public function testCreate() {

        $url = new ShorterUrl(
            new UUIDValueObject(self::INSERT_ID),
            new ShorterUrlValueObject(self::INSERT_URL),
            new ShorterShortUrlValueObject(self::INSERT_URL_SHORT),
            new IntValueObject(self::INSERT_VERSION)
        );

        $repository = new ShorterUrlEloquentRepository();
        $repository->create($url);

        $response = $repository->findById(new UUIDValueObject(self::INSERT_ID));
        $expected = [
            "id" => self::INSERT_ID,
            "url" => self::INSERT_URL,
            "shortUrl" => self::INSERT_URL_SHORT,
            "version" => self::INSERT_VERSION
        ];

        $this->assertEquals($expected, $response->toArray());

    }

    /**
     * @return void
     * @throws \App\BoundedContext\Core\Model\Exceptions\OptimisticLockException
     */
    public function testUpdate()
    {
        $url = new ShorterUrl(
             new UUIDValueObject(self::UPDATE_ID),
            new ShorterUrlValueObject(self::UPDATE_URL),
            new ShorterShortUrlValueObject(self::UPDATE_URL_SHORT),
            new IntValueObject(self::UPDATE_VERSION)
        );

        $repository = new ShorterUrlEloquentRepository();
        $repository->update($url);

        $response = $repository->findById(new UUIDValueObject(self::UPDATE_ID));
        $expected = [
            "id" => self::UPDATE_ID,
            "url" => self::UPDATE_URL,
            "shortUrl" => self::UPDATE_URL_SHORT,
            "version" => self::UPDATE_VERSION
        ];

        $this->assertEquals($expected, $response->toArray());
    }

}

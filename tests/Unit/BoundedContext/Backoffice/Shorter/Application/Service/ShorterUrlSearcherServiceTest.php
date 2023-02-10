<?php

namespace Tests\Unit\BoundedContext\Backoffice\Shorter\Application\Service;

use App\BoundedContext\Backoffice\Shorter\Application\Request\SearchShorterUrlRequest;
use App\BoundedContext\Backoffice\Shorter\Application\Service\ShorterUrlSearcherService;
use App\BoundedContext\Backoffice\Shorter\Model\Criteria\SearchShorterUrlCriteria;
use App\BoundedContext\Backoffice\Shorter\Model\Entity\ShorterUrl;
use App\BoundedContext\Backoffice\Shorter\Model\Repository\ShorterUrlRepository;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterShortUrlValueObject;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterUrlValueObject;
use App\BoundedContext\Core\Model\ValueObject\IntValueObject;
use App\BoundedContext\Core\Model\ValueObject\UUIDValueObject;
use Tests\TestCase;

class ShorterUrlSearcherServiceTest extends TestCase
{

    const TOTAL_URLS = 1;
    const SEARCH_TEXT = "google.com";
    const OFFSET = 0;
    const LIMIT = 50;

    const ID = "cc2e4716-a8a6-11ed-afa1-0242ac120002";
    const URL = "https://google.com";
    const SHORT_URL = "https://short.com?a=1";
    const VERSION = 1;

    /**
     * @return ShorterUrlRepository
     */
    private function mockDomainRepository(int $toReturnOnCount, array $toReturnSearch): ShorterUrlRepository
    {
        $urlRespository = $this->getMockBuilder(ShorterUrlRepository::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();


        // Configure the stub.
        $urlRespository->method('count')
            ->willReturn($toReturnOnCount);
        $urlRespository->method('search')
            ->willReturn($toReturnSearch);

        return $urlRespository;

    }

    /**
     * it verify that get domains service return the correct format of data
     * @return void
     */
    public function testSearch()
    {

        $url = [
            new ShorterUrl(
                new UUIDValueObject(self::ID),
                new ShorterUrlValueObject(self::URL),
                new ShorterShortUrlValueObject(self::SHORT_URL),
                new IntValueObject(self::VERSION)
            )
        ];

        $urlRepository = $this->mockDomainRepository(self::TOTAL_URLS, $url);

        $urlSearcherService = new ShorterUrlSearcherService($urlRepository);

        $request = new SearchShorterUrlRequest(
            self::SEARCH_TEXT,
            SearchShorterUrlCriteria::ORDER_BY_URL_ASC,
            self::OFFSET,
            self::LIMIT
        );

        $response = $urlSearcherService->search($request);

        $expected = [
            "data" => [
                [
                    "id" => self::ID,
                    "url" => self::URL,
                    'shortUrl' => self::SHORT_URL,
                    "version" => self::VERSION
                ]
            ],
            "offset" => self::OFFSET,
            "limit" => self::LIMIT,
            "total" => self::TOTAL_URLS
        ];

        $this->assertEquals($expected, $response->toArray());
    }

}

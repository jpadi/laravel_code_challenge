<?php

namespace Tests\Unit\BoundedContext\Backoffice\Shorter\Application\Service;

use App\BoundedContext\Backoffice\Shorter\Application\Request\GetShorterUrlRequest;
use App\BoundedContext\Backoffice\Shorter\Application\Service\ShorterUrlGetterService;
use App\BoundedContext\Backoffice\Shorter\Model\Entity\ShorterUrl;
use App\BoundedContext\Backoffice\Shorter\Model\Repository\ShorterUrlRepository;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterShortUrlValueObject;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterUrlValueObject;
use App\BoundedContext\Core\Model\ValueObject\IntValueObject;
use App\BoundedContext\Core\Model\ValueObject\UUIDValueObject;
use Tests\TestCase;

class ShorterUrlGetterServiceTest extends TestCase
{

    const ID = "ea62765e-a8aa-11ed-afa1-0242ac120002";
    const URL = "https://yahoo.com";
    const SHORT_URL = "https://short.com?a=1";
    const VERSION = 1;

/**
     * @return ShorterUrlRepository
     */
    private function mockUrlRepository(ShorterUrl $toReturnOnFindById) : ShorterUrlRepository
    {
        $urlRepository = $this->getMockBuilder(ShorterUrlRepository::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        // Configure the stub.
        $urlRepository->method('findById')
            ->willReturn($toReturnOnFindById);

        return $urlRepository;

    }

    /**
     * Test that stats() is correct
     *
     * @return void
     */
    public function testGet()
    {
        $url = new ShorterUrl(
            new UUIDValueObject(self::ID),
            new ShorterUrlValueObject(self::URL),
            new ShorterShortUrlValueObject(self::SHORT_URL),
            new IntValueObject(self::VERSION)
        );
        $urlRepository = $this->mockUrlRepository($url);
        $statsService = new ShorterUrlGetterService($urlRepository);

        $request = new GetShorterUrlRequest(
            self::ID
        );

        $response = $statsService->get($request);

        $this->assertEquals(self::ID, $response->getId());
        $this->assertEquals(self::URL, $response->getUrl());
        $this->assertEquals(self::SHORT_URL, $response->getShortUrl());
        $this->assertEquals(self::VERSION, $response->getVersion());
    }
}

<?php

namespace Tests\Unit\BoundedContext\Backoffice\Shorter\Application\Service;

use App\BoundedContext\Backoffice\Shorter\Application\Request\ShortenerUrlShortenerRequest;
use App\BoundedContext\Backoffice\Shorter\Application\Service\ShorterUrlShortenerService;
use App\BoundedContext\Backoffice\Shorter\Model\Entity\ShorterShortUrl;
use App\BoundedContext\Backoffice\Shorter\Model\Entity\ShorterUrl;
use App\BoundedContext\Backoffice\Shorter\Model\Event\ShorterUrlUpdatedEvent;
use App\BoundedContext\Backoffice\Shorter\Model\Repository\ShorterShortUrlRepository;
use App\BoundedContext\Backoffice\Shorter\Model\Repository\ShorterUrlRepository;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterShortUrlValueObject;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterUrlValueObject;
use App\BoundedContext\Core\Model\EventBus\EventBus;
use App\BoundedContext\Core\Model\ValueObject\IntValueObject;
use App\BoundedContext\Core\Model\ValueObject\UUIDValueObject;
use Tests\IntegrationTestCase;

class ShorterUrlShortenerServiceTest extends IntegrationTestCase
{

    const ID = "fe0c8e3e-a7f0-11ed-afa1-0242ac120002";
    const URL = "https://yahoo.es";
    const SHORT_URL = "";
    const VERSION=1;

    const GENERATED_SHORT_URL = "https://short.com?a=1";

    /**
     * @param ShorterUrl $url
     * @param ShorterUrl|null $capturedUrl
     * @return ShorterUrlRepository
     */
    private function mockShorterUrlRepository(ShorterUrl $url, ?ShorterUrl &$capturedUrl): ShorterUrlRepository
    {
        $shortUrlRepository = $this->getMockBuilder(ShorterUrlRepository::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $shortUrlRepository->method("findById")->willReturn($url);

          /** @var TYPE_NAME $this */
        $shortUrlRepository->expects($this->once())
            ->method("update")
            ->with(
                $this->captureArg($capturedUrl)
            );

        return $shortUrlRepository;
    }

    /**
     * @param ShorterShortUrl $shortUrl
     * @return ShorterShortUrlRepository
     */
    private function mockShorterShortUrlRepository(ShorterShortUrl $shortUrl): ShorterShortUrlRepository
    {
        $urlRepository = $this->getMockBuilder(ShorterShortUrlRepository::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $urlRepository->method("findByUrl")->willReturn($shortUrl);

        return $urlRepository;
    }

    /**
     * @param ShorterUrlUpdatedEvent|null $capturedEvent
     * @return EventBus
     */
    private function mockEventBus(?ShorterUrlUpdatedEvent &$capturedEvent): EventBus
    {
        $eventBus = $this->getMockBuilder(EventBus::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        /** @var TYPE_NAME $this */
        $eventBus->expects($this->once())
            ->method("publish")
            ->with(
                $this->captureArg($capturedEvent)
            );

        return $eventBus;
    }


    public function testShort() {

        $url = new ShorterUrl(
            new UUIDValueObject(self::ID),
            new ShorterUrlValueObject(self::URL),
            new ShorterShortUrlValueObject(self::SHORT_URL),
            new IntValueObject(self::VERSION)
        );

        $shortUrl = new ShorterShortUrl(
            new ShorterShortUrlValueObject(self::GENERATED_SHORT_URL)
        );

        $shortenerRequestRequest = new ShortenerUrlShortenerRequest(
            self::ID
        );

        $shortUrlRepository = $this->mockShorterShortUrlRepository($shortUrl);

        /**
         * @var ShorterUrl $capturedUrl
         */
        $capturedUrl = null;
        $urlRepository = $this->mockShorterUrlRepository($url, $capturedUrl);

        /**
         * @var ShorterUrlUpdatedEvent $capturedEvent
         */
        $capturedEvent = null;
        $eventBus = $this->mockEventBus($capturedEvent);

        $domainUpdaterService = new ShorterUrlShortenerService($shortUrlRepository, $urlRepository, $eventBus);
        $domainUpdaterService->short($shortenerRequestRequest);

        //asserts for domain
        $this->assertSame($url, $capturedUrl);

        //assert for event
        $this->assertEquals(self::ID, $capturedEvent->getId());
        $this->assertEquals(self::URL, $capturedEvent->getUrl());
        $this->assertEquals(self::GENERATED_SHORT_URL, $capturedEvent->getShortUrl());
        $this->assertEquals(self::VERSION+1, $capturedEvent->getVersion());

    }

}

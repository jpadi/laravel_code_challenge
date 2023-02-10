<?php

namespace Tests\Unit\BoundedContext\Backoffice\Shorter\Application\Service;

use App\BoundedContext\Backoffice\Shorter\Application\Request\CreateShorterUrlCreatorRequest;
use App\BoundedContext\Backoffice\Shorter\Application\Service\ShorterUrlCreatorService;
use App\BoundedContext\Backoffice\Shorter\Model\Entity\ShorterUrl;
use App\BoundedContext\Backoffice\Shorter\Model\Event\ShorterUrlCreatedEvent;
use App\BoundedContext\Backoffice\Shorter\Model\Repository\ShorterUrlRepository;
use App\BoundedContext\Core\Model\EventBus\EventBus;
use Tests\TestCase;

class ShorterUrlCreatorServiceTest extends TestCase
{
    const INSERT_ID = "53231e5e-23b6-4552-a488-e4c8cdf0dfa0";
    const INSERT_URL = "https://www.yahoo.es";
    const INSERT_VERSION = 1;

    /**
     * @param ShorterUrl |null $capturedUrl will capture the domain passed to create method of repository
     * @return ShorterUrlRepository
     */
    private function mockDomainRepository(?ShorterUrl &$capturedUrl): ShorterUrlRepository
    {
        $domainRepository = $this->getMockBuilder(ShorterUrlRepository::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();


        /** @var TYPE_NAME $this */
        $domainRepository->expects($this->once())
            ->method("create")
            ->with(
                $this->captureArg($capturedUrl)
            );

        return $domainRepository;
    }

    /**
     * @param ShorterUrlCreatedEvent $capturedEvent will capture the event captured on the dispatch of the event bus
     * @return EventBus
     */
    private function mockEventBus(?ShorterUrlCreatedEvent &$capturedEvent): EventBus
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

    public function testCreate() {

        $createUrlRequest = new CreateShorterUrlCreatorRequest(
            self::INSERT_ID,
            self::INSERT_URL
        );

        /**
         * @var ShorterUrl $capturedUrl
         */
        $capturedUrl = null;
        $urlRepository = $this->mockDomainRepository($capturedUrl);

        /**
         * @var ShorterUrlCreatedEvent $capturedEvent
         */
        $capturedEvent = null;
        $eventBus = $this->mockEventBus($capturedEvent);

        $urlCreatorService = new ShorterUrlCreatorService($urlRepository, $eventBus);
        $urlCreatorService->create($createUrlRequest);

        //asserts for domain
        $this->assertEquals(self::INSERT_ID, $capturedUrl->getId()->getString());
        $this->assertEquals(self::INSERT_URL, $capturedUrl->getUrl()->getString());
        $this->assertEquals(self::INSERT_VERSION, $capturedUrl->getVersion()->getInt());

        //assert for event
        $this->assertEquals(self::INSERT_ID, $capturedEvent->getId());
        $this->assertEquals(self::INSERT_URL, $capturedEvent->getUrl());
        $this->assertEquals(self::INSERT_VERSION, $capturedEvent->getVersion());

    }
}

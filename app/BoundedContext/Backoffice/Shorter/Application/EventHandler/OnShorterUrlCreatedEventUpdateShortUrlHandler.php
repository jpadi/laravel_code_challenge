<?php

namespace App\BoundedContext\Backoffice\Shorter\Application\EventHandler;

use App\BoundedContext\Backoffice\Shorter\Application\Request\ShortenerUrlShortenerRequest;
use App\BoundedContext\Backoffice\Shorter\Application\Service\ShorterUrlShortenerService;
use App\BoundedContext\Backoffice\Shorter\Model\Event\ShorterUrlCreatedEvent;
use App\BoundedContext\Core\Model\Exceptions\EntityNotFound;
use App\BoundedContext\Core\Model\Exceptions\EventAttributeNotFound;
use App\BoundedContext\Core\Model\Exceptions\InvalidUUIDException;



class OnShorterUrlCreatedEventUpdateShortUrlHandler
{

    /**
     * @var ShorterUrlShortenerService
     */
    private $shortenerService;

    /**
     * @param ShorterUrlShortenerService $shortenerService
     */
    public function __construct(ShorterUrlShortenerService $shortenerService)
    {
        $this->shortenerService = $shortenerService;
    }

    /**
     * @param ShorterUrlCreatedEvent $event
     * @return void
     * @throws EntityNotFound
     * @throws EventAttributeNotFound
     * @throws InvalidUUIDException
     */
    public function handle(ShorterUrlCreatedEvent $event) {
        $request = new ShortenerUrlShortenerRequest(
            $event->getId()
        );

        $this->shortenerService->short($request);
    }

}

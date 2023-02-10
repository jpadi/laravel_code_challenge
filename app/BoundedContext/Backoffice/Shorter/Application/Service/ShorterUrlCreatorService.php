<?php

namespace App\BoundedContext\Backoffice\Shorter\Application\Service;

use App\BoundedContext\Backoffice\Shorter\Application\Request\CreateShorterUrlCreatorRequest;
use App\BoundedContext\Backoffice\Shorter\Model\Entity\ShorterUrl;
use App\BoundedContext\Backoffice\Shorter\Model\Exception\ShorterUrlExistsException;
use App\BoundedContext\Backoffice\Shorter\Model\Repository\ShorterUrlRepository;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterShortUrlValueObject;
use App\BoundedContext\Backoffice\Shorter\Model\ValueObject\ShorterUrlValueObject;
use App\BoundedContext\Core\Model\EventBus\EventBus;
use App\BoundedContext\Core\Model\ValueObject\UUIDValueObject;

class ShorterUrlCreatorService
{

    /**
     * @var ShorterUrlRepository
     */
    private $shorterUrlRepository;

       /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * @param EventBus $eventBus
     * @param ShorterUrlRepository $shorterUrlRepository
     */
    public function __construct(ShorterUrlRepository $shorterUrlRepository, EventBus $eventBus)
    {
        $this->shorterUrlRepository = $shorterUrlRepository;
        $this->eventBus = $eventBus;
    }

    public function create(CreateShorterUrlCreatorRequest $request) {

        $url = ShorterUrl::create(
            new UUIDValueObject($request->getId()),
            new ShorterUrlValueObject($request->getUrl()),
            new ShorterShortUrlValueObject("")
        );

        if ($this->shorterUrlRepository->searchByUrl($url->getUrl())) {
              throw new ShorterUrlExistsException();
        }

        $this->shorterUrlRepository->create($url);

        $this->eventBus->publish(... $url->pollEvents());
    }

}

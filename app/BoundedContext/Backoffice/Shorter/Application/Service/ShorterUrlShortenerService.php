<?php

namespace App\BoundedContext\Backoffice\Shorter\Application\Service;

use App\BoundedContext\Backoffice\Shorter\Application\Request\ShortenerUrlShortenerRequest;
use App\BoundedContext\Backoffice\Shorter\Model\Repository\ShorterShortUrlRepository;
use App\BoundedContext\Backoffice\Shorter\Model\Repository\ShorterUrlRepository;
use App\BoundedContext\Core\Model\EventBus\EventBus;
use App\BoundedContext\Core\Model\ValueObject\IntValueObject;
use App\BoundedContext\Core\Model\ValueObject\UUIDValueObject;
use App\BoundedContext\Core\Model\Exceptions\EntityNotFound;
use App\BoundedContext\Core\Model\Exceptions\EventAttributeNotFound;
use App\BoundedContext\Core\Model\Exceptions\InvalidUUIDException;

class ShorterUrlShortenerService
{

    /**
     * @var ShorterShortUrlRepository
     */
    private $shorterShortUrlRepository;

    /**
     * @var ShorterUrlRepository
     */
    private $shorterUrlRepository;

    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * @param ShorterShortUrlRepository $shorterShortUrlRepository
     * @param ShorterUrlRepository $shorterUrlRepository
     * @param EventBus $eventBus
     */
    public function __construct(ShorterShortUrlRepository $shorterShortUrlRepository, ShorterUrlRepository $shorterUrlRepository, EventBus $eventBus)
    {
        $this->shorterShortUrlRepository = $shorterShortUrlRepository;
        $this->shorterUrlRepository = $shorterUrlRepository;
        $this->eventBus = $eventBus;
    }

    /**
     * @param ShortenerUrlShortenerRequest $request
     * @return void
     * @throws EntityNotFound
     * @throws EventAttributeNotFound
     * @throws InvalidUUIDException
     */
    public function short(ShortenerUrlShortenerRequest $request): void {

        $url = $this->shorterUrlRepository->findById(new UUIDValueObject($request->getId()));

        // already has short url dont need to do it again
        if ($url->getShortUrl()->getString() !== "") {
            return;
        }

        $shortUrl = $this->shorterShortUrlRepository->findByUrl($url->getUrl());

        $url->update(
            $url->getUrl(),
            $shortUrl->getShortUrl(),
            new IntValueObject($url->getVersion()->getInt()+1)
        );

        $this->shorterUrlRepository->update($url);

        $this->eventBus->publish(...$url->pollEvents());

    }

}

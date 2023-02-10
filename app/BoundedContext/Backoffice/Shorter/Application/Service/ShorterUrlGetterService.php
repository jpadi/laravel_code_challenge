<?php

namespace App\BoundedContext\Backoffice\Shorter\Application\Service;

use App\BoundedContext\Backoffice\Shorter\Application\Request\GetShorterUrlRequest;
use App\BoundedContext\Backoffice\Shorter\Application\Response\SearchShorterUrlItemResponse;
use App\BoundedContext\Backoffice\Shorter\Model\Repository\ShorterUrlRepository;
use App\BoundedContext\Core\Model\ValueObject\UUIDValueObject;

class ShorterUrlGetterService
{

    /**
     * @var ShorterUrlRepository
     */
    private $urlRepository;

    /**
     * @param ShorterUrlRepository $urlRepository
     */
    public function __construct(ShorterUrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    /**
     * @param GetShorterUrlRequest $request
     * @return SearchShorterUrlItemResponse
     */
    public function get(GetShorterUrlRequest $request) : SearchShorterUrlItemResponse{

        $url = $this->urlRepository->findById(new UUIDValueObject($request->getId()));

        return new SearchShorterUrlItemResponse(
            $url->getId()->getString(),
            $url->getUrl()->getString(),
            $url->getShortUrl()->getString(),
            $url->getVersion()->getInt()
        );
    }
}

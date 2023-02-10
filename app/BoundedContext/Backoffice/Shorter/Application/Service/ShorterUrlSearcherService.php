<?php

namespace App\BoundedContext\Backoffice\Shorter\Application\Service;

use App\BoundedContext\Backoffice\Shorter\Application\Request\SearchShorterUrlRequest;
use App\BoundedContext\Backoffice\Shorter\Application\Response\SearchShorterUrlItemResponse;
use App\BoundedContext\Backoffice\Shorter\Application\Response\SearchShorterUrlResponse;
use App\BoundedContext\Backoffice\Shorter\Model\Criteria\SearchShorterUrlCriteria;
use App\BoundedContext\Backoffice\Shorter\Model\Repository\ShorterUrlRepository;
use App\BoundedContext\Backoffice\Shorter\Model\Exception\InvalidSearchShorterUrlCriteriaOrderBy;

class ShorterUrlSearcherService
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
     * @param SearchShorterUrlRequest $request
     * @return SearchShorterUrlResponse
     * @throws InvalidSearchShorterUrlCriteriaOrderBy
     */
    public function search(SearchShorterUrlRequest $request) : SearchShorterUrlResponse{

        $criteria = new SearchShorterUrlCriteria(
            $request->getText(),
            $request->getOrderBy(),
            $request->getOffset(),
            $request->getLimit()
        );

        $total = $this->urlRepository->count($criteria);
        $urlArray = $this->urlRepository->search($criteria);

        $data = [];
        foreach ($urlArray as $url) {
            $data[] = new SearchShorterUrlItemResponse(
                $url->getId()->getString(),
                $url->getUrl()->getString(),
                $url->getShortUrl()->getString(),
                $url->getVersion()->getInt()
            );
        }

        return new SearchShorterUrlResponse($data, $request->getOffset(), $request->getLimit(), $total);
    }

}

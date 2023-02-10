<?php

namespace App\BoundedContext\Backoffice\Shorter\Application\QueryHandler;

use App\BoundedContext\Backoffice\Shorter\Application\Query\SearchShorterUrlQuery;
use App\BoundedContext\Backoffice\Shorter\Application\Request\SearchShorterUrlRequest;
use App\BoundedContext\Backoffice\Shorter\Application\Response\SearchShorterUrlResponse;
use App\BoundedContext\Backoffice\Shorter\Application\Service\ShorterUrlSearcherService;

class SearchShorterUrlQueryHandler
{

    /**
     * @var ShorterUrlSearcherService
     */
    private $searchService;

    /**
     * @param ShorterUrlSearcherService $searchService
     */
    public function __construct(ShorterUrlSearcherService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function handle(SearchShorterUrlQuery $query): SearchShorterUrlResponse {
        $request = new SearchShorterUrlRequest(
            $query->getText(),
            $query->getOrderBy(),
            $query->getOffset(),
            $query->getLimit()
        );
        return $this->searchService->search($request);
    }
}

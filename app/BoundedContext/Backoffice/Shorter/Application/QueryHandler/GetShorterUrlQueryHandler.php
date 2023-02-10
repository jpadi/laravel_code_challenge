<?php

namespace App\BoundedContext\Backoffice\Shorter\Application\QueryHandler;

use App\BoundedContext\Backoffice\Shorter\Application\Query\GetShorterUrlQuery;
use App\BoundedContext\Backoffice\Shorter\Application\Request\GetShorterUrlRequest;
use App\BoundedContext\Backoffice\Shorter\Application\Response\SearchShorterUrlItemResponse;
use App\BoundedContext\Backoffice\Shorter\Application\Service\ShorterUrlGetterService;
use App\BoundedContext\Core\Model\QueryBus\QueryHandler;

class GetShorterUrlQueryHandler implements QueryHandler
{

    /**
     * @var ShorterUrlGetterService
     */
    private $getterService;

    /**
     * @param ShorterUrlGetterService $getterService
     */
    public function __construct(ShorterUrlGetterService $getterService)
    {
        $this->getterService = $getterService;
    }

    /**
     * @param GetShorterUrlQuery $query
     * @return SearchShorterUrlItemResponse
     */
    public function handle(GetShorterUrlQuery $query) : SearchShorterUrlItemResponse{
        $request = new GetShorterUrlRequest($query->getId());
        return $this->getterService->get($request);
    }

}

<?php

namespace App\BoundedContext\Backoffice\Auth\Application\QueryHandler;

use App\BoundedContext\Backoffice\Auth\Application\Query\CheckAuthTokenQuery;
use App\BoundedContext\Backoffice\Auth\Application\Request\AuthTokenCheckerRequest;
use App\BoundedContext\Backoffice\Auth\Application\Response\AuthTokenCheckerResponse;
use App\BoundedContext\Backoffice\Auth\Application\Service\AuthTokenCheckerService;
use App\BoundedContext\Core\Model\QueryBus\QueryHandler;

class CheckAuthTokenQueryQueryHandler implements QueryHandler
{

    /**
     * @var AuthTokenCheckerService
     */
    private $authTokenCheckerService;

    /**
     * @param AuthTokenCheckerService $authTokenCheckerService
     */
    public function __construct(AuthTokenCheckerService $authTokenCheckerService)
    {
        $this->authTokenCheckerService = $authTokenCheckerService;
    }

    /**
     * @param CheckAuthTokenQuery $query
     * @return AuthTokenCheckerResponse
     */
    public function handle(CheckAuthTokenQuery $query): AuthTokenCheckerResponse {
        $request = new AuthTokenCheckerRequest($query->getToken());
        return $this->authTokenCheckerService->check($request);
    }

}

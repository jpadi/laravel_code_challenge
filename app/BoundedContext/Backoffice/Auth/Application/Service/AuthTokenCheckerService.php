<?php

namespace App\BoundedContext\Backoffice\Auth\Application\Service;

use App\BoundedContext\Backoffice\Auth\Application\Request\AuthTokenCheckerRequest;
use App\BoundedContext\Backoffice\Auth\Application\Response\AuthTokenCheckerResponse;
use App\BoundedContext\Backoffice\Auth\Model\Exception\InvalidAuthToken;
use App\BoundedContext\Backoffice\Auth\Model\ValueObject\AuthToken;

class AuthTokenCheckerService
{

    public function check(AuthTokenCheckerRequest $request) {

        try {
            AuthToken::create($request->getToken());
            $response = new AuthTokenCheckerResponse(true);
        } catch (InvalidAuthToken $exception) {
            $response = new AuthTokenCheckerResponse(false);
        }

        return $response;

    }

}

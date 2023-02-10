<?php

namespace App\Http\Middleware;

use App\BoundedContext\Backoffice\Auth\Application\Query\CheckAuthTokenQuery;
use App\BoundedContext\Core\Model\QueryBus\QueryBus;
use App\BoundedContext\Core\Model\Responses\ErrorResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class AuthCheck
{

    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * @param QueryBus $queryBus
     */
    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }


    public function handle(Request $request, \Closure $next) {


        $token = $request->header("Authorization", "");
        $token = str_replace("Bearer " , "",trim($token));

        if(!$this->validate($token)) {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
            $response->setContent(ErrorResponse::create("auth_invalid_token", "Not authenticated request"));
            return $response;
        }

        return $next($request);
    }

    private function validate($token): bool {

        $query = new CheckAuthTokenQuery($token);
        $response = $this->queryBus->query($query)->toArray();

        return $response["valid"];
    }

}

<?php

namespace App\Http\Controllers\API\Shorter;

use App\BoundedContext\Backoffice\Shorter\Application\Query\SearchShorterUrlQuery;
use App\BoundedContext\Core\Model\QueryBus\QueryBus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SearchUrlController extends Controller
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


    /**
     * @param Request $request
     * @return Response
     */
    public function search(Request $request): Response {

        $query = new SearchShorterUrlQuery(
            $request->query("text", "")??"",
            $request->query("orderBy", "")??"",
            (int)$request->query("offset", 0)??0,
            (int)$request->query("limit", 50)??0

        );

        return new Response($this->queryBus->query($query)->toArray(), Response::HTTP_OK);

    }

}

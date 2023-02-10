<?php

namespace App\Http\Controllers\API\Shorter;


use App\BoundedContext\Backoffice\Domains\Application\Commands\CreateDomainsDomainCommand;
use App\BoundedContext\Backoffice\Shorter\Application\Command\CreateShorterUrlCommand;
use App\BoundedContext\Backoffice\Shorter\Application\Query\GetShorterUrlQuery;
use App\BoundedContext\Backoffice\Shorter\Model\Exception\InvalidShorterUrlException;
use App\BoundedContext\Backoffice\Shorter\Model\Exception\ShorterUrlExistsException;
use App\BoundedContext\Core\Model\CommandBus\CommandBus;
use App\BoundedContext\Core\Model\QueryBus\Query;
use App\BoundedContext\Core\Model\Responses\ErrorResponse;
use App\BoundedContext\Core\Model\ValueObject\UUIDValueObject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\BoundedContext\Core\Model\Exceptions\InvalidUUIDException;

class CreateUrlController extends Controller
{

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var \App\BoundedContext\Core\Model\QueryBus\QueryBus
     */
    private $queryBus;

    /**
     * @param CommandBus $commandBus
     * @param \App\BoundedContext\Core\Model\QueryBus\QueryBus $queryBus
     */
    public function __construct(CommandBus $commandBus, \App\BoundedContext\Core\Model\QueryBus\QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        try {

            $id = UUIDValueObject::generate()->getString();
            $id = $request->json("id", $id) ?? $id;

            $createCommand = new CreateShorterUrlCommand(
                $id,
                $request->json("url", "") ?? ""
            );

            $this->commandBus->dispatch($createCommand);

            // maybe here is better return all url entity like this but the requirement is to return {"url": "{{shortUrl}}"}
            // $response = new Response($this->queryBus->query(new GetShorterUrlQuery($id))->toArray(), Response::HTTP_OK);

            $queryResponse = $this->queryBus->query(new GetShorterUrlQuery($id))->toArray();

            $responseData = [
                "url" => $queryResponse["shortUrl"]
            ];

            //TODO: if the commandBus is async we should do a wait here
            $response = new Response($responseData, Response::HTTP_OK);

        } catch (InvalidUUIDException $exception) {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent(ErrorResponse::create("url_create_invalid_uuid", "Invalid uuid"));

        } catch (InvalidShorterUrlException $exception) {

            $response = new Response();
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent(ErrorResponse::create("url_create_invalid_url", "Invalid url"));
        } catch (ShorterUrlExistsException $exception) {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent(ErrorResponse::create("url_create_url_exists", "The url already exists in database"));
        } catch (\Exception $exception) {

            $response = new Response();
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent(ErrorResponse::create("url_create_server_error", "Server error"));
        }
        return $response;
    }

}

<?php

namespace App\BoundedContext\Backoffice\Shorter\Application\CommandHandler;

use App\BoundedContext\Backoffice\Shorter\Application\Command\CreateShorterUrlCommand;
use App\BoundedContext\Backoffice\Shorter\Application\Request\CreateShorterUrlCreatorRequest;
use App\BoundedContext\Backoffice\Shorter\Application\Service\ShorterUrlCreatorService;

class CreateShorterUrlCommandHandler
{

    /**
     * @var ShorterUrlCreatorService
     */
    private $creatorService;

    /**
     * @param ShorterUrlCreatorService $creatorService
     */
    public function __construct(ShorterUrlCreatorService $creatorService)
    {
        $this->creatorService = $creatorService;
    }

    public function handle(CreateShorterUrlCommand $command): void {
        $request = new CreateShorterUrlCreatorRequest(
            $command->getId(),
            $command->getUrl()
        );
        $this->creatorService->create($request);
    }

}

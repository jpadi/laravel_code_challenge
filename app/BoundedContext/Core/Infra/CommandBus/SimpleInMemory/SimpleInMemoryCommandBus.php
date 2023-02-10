<?php

namespace App\BoundedContext\Core\Infra\CommandBus\SimpleInMemory;

use App\BoundedContext\Core\Model\CommandBus\Command;
use App\BoundedContext\Core\Model\CommandBus\CommandBus;
use App\BoundedContext\Core\Model\Exceptions\CommandHandlerNotFound;

class SimpleInMemoryCommandBus implements CommandBus
{

    /**
     * @var array
     */
    private $commandHandlers = [];

    public function addHandler(string $commandName, callable $commandHandler)
    {
        $this->commandHandlers[$commandName] = $commandHandler;
    }

    /**
     * @param Command $command
     * @return void
     * @throws CommandHandlerNotFound
     */
    public function dispatch(Command $command): void
    {
        $commandHandler = $this->commandHandlers[get_class($command)] ?? null;
        if ($commandHandler === null) {
            throw  new CommandHandlerNotFound($command);
        }
        call_user_func($commandHandler, $command);
    }
}

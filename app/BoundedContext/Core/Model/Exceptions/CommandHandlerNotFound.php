<?php

namespace App\BoundedContext\Core\Model\Exceptions;

use App\BoundedContext\Core\Model\CommandBus\Command;

class CommandHandlerNotFound extends \Exception
{
    /**
     * @var Command
     */
    private $command;

    /**
     * @param Command $command
     */
    public function __construct(Command $command)
    {
        parent::__construct("No command handler found for \"" . get_class($command) . "\"");
        $this->command = $command;
    }

}

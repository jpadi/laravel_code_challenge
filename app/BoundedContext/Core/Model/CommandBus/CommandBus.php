<?php

namespace App\BoundedContext\Core\Model\CommandBus;

interface CommandBus
{
    public function dispatch(Command $command): void;
}

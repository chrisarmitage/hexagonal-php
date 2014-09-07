<?php

namespace Hex\Domain\Interfaces;

interface CommandBus
{
    public function execute($command);
}

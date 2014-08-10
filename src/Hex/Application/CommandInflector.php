<?php

namespace Hex\Application;

class CommandInflector
{
    public function getHandlerClass($command) {
        return str_replace('Command', 'Handler', get_class($command));
    }
}
<?php

namespace Hex\Application;

class SimpleCommandBus implements \Hex\Domain\Interfaces\CommandBus
{
    protected $container;
    
    protected $inflector;
    
    public function __construct(
        \Illuminate\Container\Container $container,
        \Hex\Application\CommandInflector $inflector)
    {
        $this->container = $container;
        $this->inflector = $inflector;
    }

    
    public function execute($command) {
        return $this->resolveHandler($command)->handle($command);
    }
    
    public function resolveHandler($command) {
        return $this->container->make($this->inflector->getHandlerClass($command));
        //$handlerName = $this->inflector->getHandlerClass($command);
        //return new $handlerName;
    }
}

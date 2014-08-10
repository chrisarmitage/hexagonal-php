<?php

namespace Hex\Application\Handlers;

use \Hex\Application\Dispatcher as Dispatcher;

class AddCustomerDocumentHandler implements \Hex\Application\Interfaces\Handler
{
    protected $dispatcher;
    
    function __construct(Dispatcher $dispatcher) {
        $this->dispatcher = $dispatcher;
    }

    
    public function handle($command) {
        $customerDocument = new \Hex\Domain\CustomerDocument();
        
        $customerDocument->setBookingReference($command->getBookingReference());
        
        /**
         * @TODO Save
         */
        $this->dispatcher->dispatch($customerDocument->flushEvents());
    }
}
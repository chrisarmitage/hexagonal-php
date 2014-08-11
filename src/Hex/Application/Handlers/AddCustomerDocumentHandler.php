<?php

namespace Hex\Application\Handlers;

use \Hex\Application\Dispatcher as Dispatcher;
use \Hex\Application\CustomerDocumentRepository as Repository;

class AddCustomerDocumentHandler implements \Hex\Application\Interfaces\Handler
{
    protected $dispatcher;
    
    protected $repository;
    
    function __construct(Dispatcher $dispatcher, Repository $repository) {
        $this->dispatcher = $dispatcher;
        $this->repository = $repository;
    }

    
    public function handle($command) {
        $customerDocument = new \Hex\Domain\CustomerDocument();
        
        $customerDocument->setBookingReference($command->getBookingReference())
                ->setDocumentType($command->getDocumentType())
                ->setDocumentPath($command->getDocumentPath());
        
        $lastInsertID = $this->repository->add($customerDocument);
        echo "Uploading record {$lastInsertID} / ";
        echo $this->repository->findByCustomerDocumentID($lastInsertID)->getBookingReference() . '<br />';
        
        
        $this->dispatcher->dispatch($customerDocument->flushEvents());
    }
}
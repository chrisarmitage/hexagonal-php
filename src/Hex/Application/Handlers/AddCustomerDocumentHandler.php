<?php

namespace Hex\Application\Handlers;

use \Hex\Application\Dispatcher as Dispatcher;
use \Hex\Application\CustomerDocumentRepository as Repository;
use \Hex\Application\CustomerDocumentStorage as DocumentStorage;

class AddCustomerDocumentHandler implements \Hex\Application\Interfaces\Handler
{
    protected $dispatcher;
    
    protected $repository;
    
    protected $documentStorage;
    
    function __construct(Dispatcher $dispatcher, Repository $repository, DocumentStorage $documentStorage) {
        $this->dispatcher = $dispatcher;
        $this->repository = $repository;
        $this->documentStorage = $documentStorage;
    }

    
    public function handle($command) {
        $customerDocument = new \Hex\Domain\CustomerDocument();
        
        $customerDocument->setBookingReference($command->getBookingReference())
                ->setDocumentType($command->getDocumentType())
                ->setDocumentPath($command->getDocumentPath());
        
        $lastInsertID = $this->repository->add($customerDocument);
        
        $this->documentStorage->addToFolder($customerDocument);
        
        $customerDocument->raise(new \Hex\Domain\Events\CustomerDocumentFolderUpdatedEvent($customerDocument->getBookingReference()));
        
        //echo "Uploading record {$lastInsertID} / ";
        //echo $this->repository->findByCustomerDocumentID($lastInsertID)->getBookingReference() . '<br />';
        
        
        $this->dispatcher->dispatch($customerDocument->flushEvents());
    }
}

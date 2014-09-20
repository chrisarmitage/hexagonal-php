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
    
    public function __construct(
        Dispatcher $dispatcher,
        Repository $repository,
        DocumentStorage $documentStorage)
    {
        $this->dispatcher = $dispatcher;
        $this->repository = $repository;
        $this->documentStorage = $documentStorage;
    }

    
    public function handle($command) {
        $customerDocument = new \Hex\Domain\CustomerDocument(
            $command->getBookingReference(),
            $command->getDocumentType(),
            $command->getDocumentPath()
        );
        
        $this->repository->add($customerDocument);
        
        $documentPath = $this->documentStorage->addToFolder($customerDocument);
        
        $customerDocument->setDocumentPath($documentPath);
        
        $customerDocument->raise(new \Hex\Domain\Events\CustomerDocumentAddedEvent($customerDocument));
        
        $customerDocument->raise(
            new \Hex\Domain\Events\CustomerDocumentFolderUpdatedEvent(
                $customerDocument->getBookingReference()
            )
        );
        
        $this->dispatcher->dispatch($customerDocument->flushEvents());
    }
}

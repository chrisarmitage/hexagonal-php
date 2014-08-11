<?php

namespace Hex\Application;

use \Hex\Domain\CustomerDocument as CustomerDocument;

class CustomerDocumentRepository
{
    protected $gateway;
    
    protected $factory;
    
    public function __construct(
            \Hex\InMemoryPersistence $gateway,
            \Hex\Application\CustomerDocumentFactory $factory
            ) {
        $this->gateway = $gateway;
        $this->factory = $factory;
    }

    
    public function add(CustomerDocument $customerDocument) {
        $lastInsertID = $this->gateway->persist(array(
            $customerDocument->getBookingReference(),
            $customerDocument->getDocumentType(),
            $customerDocument->getDocumentPath(),
        ));
        
        return $lastInsertID;
    }
    
    public function findByCustomerDocumentID($id) {
        return $this->findAll()[$id];
    }
    
    public function findAll() {
        $allCustomerDocumentsData = $this->gateway->retrieveAll();
        $customerDocuments = array();
        foreach ($allCustomerDocumentsData as $customerDocumentData) {
            $customerDocuments[] = $this->factory->make($customerDocumentData);
        }
        return $customerDocuments;
    }
            
}
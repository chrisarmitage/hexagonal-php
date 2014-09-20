<?php

namespace Hex\Application;

use \Hex\Domain\CustomerDocument as CustomerDocument;

class CustomerDocumentRepository
{
    protected $gateway;
    
    protected $factory;
    
    public function __construct(
        \Hex\Application\CustomerDocumentGateway $gateway,
        \Hex\Application\CustomerDocumentFactory $factory
    ) {
        $this->gateway = $gateway;
        $this->factory = $factory;
    }

    
    public function add(CustomerDocument $customerDocument) {
        $lastInsertID = $this->gateway->persist(
            array(
                'reference' => $customerDocument->getBookingReference(),
                'type' => $customerDocument->getDocumentType(),
                'path' => $customerDocument->getDocumentPath(),
            )
        );
        
        return $lastInsertID;
    }
    
    public function findByDocumentId($id) {
        return array_filter(
            $this->findAll(),
            function (CustomerDocument $customerDocument) use ($id) {
                return $customerDocument->getId() == $id;
            }
        );
    }
    
    public function findByDocumentType($documentType) {
        return array_filter(
            $this->findAll(),
            function (CustomerDocument $customerDocument) use ($documentType) {
                return $customerDocument->getDocumentType() == $documentType;
            }
        );
    }
    
    public function findByReference($reference) {
        return array_filter(
            $this->findAll(),
            function (CustomerDocument $customerDocument) use ($reference) {
                return $customerDocument->getBookingReference() == $reference;
            }
        );
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

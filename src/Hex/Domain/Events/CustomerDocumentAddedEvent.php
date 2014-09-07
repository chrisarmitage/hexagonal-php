<?php

namespace Hex\Domain\Events;

class CustomerDocumentAddedEvent implements \Hex\Domain\Interfaces\EventInterface
{
    protected $customerDocument;
    
    public function __construct(\Hex\Domain\CustomerDocument $customerDocument) {
        $this->customerDocument = $customerDocument;
    }
    
    public function getCustomerDocument() {
        return $this->customerDocument;
    }
    
    public function name() {
        return 'customer_document.added';
    }
}

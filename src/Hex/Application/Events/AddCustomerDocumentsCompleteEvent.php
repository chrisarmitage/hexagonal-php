<?php

namespace Hex\Application\Events;

class AddCustomerDocumentsCompleteEvent implements \Hex\Domain\Interfaces\EventInterface
{
    protected $numberOfDocumentsAdded;
    
    public function __construct($numberOfDocumentsAdded) {
        $this->numberOfDocumentsAdded = $numberOfDocumentsAdded;
    }
    
    public function getNumberOfDocumentsAdded() {
        return $this->numberOfDocumentsAdded;
    }
    
    public function name() {
        return 'add_customer_documents.complete';
    }
}
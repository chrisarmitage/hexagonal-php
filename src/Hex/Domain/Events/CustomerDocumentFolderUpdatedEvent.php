<?php

namespace Hex\Domain\Events;

class CustomerDocumentFolderUpdatedEvent implements \Hex\Domain\Interfaces\EventInterface
{
    protected $bookingReference;
    
    public function __construct($bookingReference) {
        $this->bookingReference = $bookingReference;
    }
    
    public function getBookingReference() {
        return $this->bookingReference;
    }
    
    public function name() {
        return 'customer_folder.updated';
    }
}
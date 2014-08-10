<?php

namespace Hex\Domain;

class CustomerDocument
{
    use \Hex\Domain\Eventable;
    
    protected $bookingReference;
    
    /**
     * Constraint: A booking reference must be present
     * 
     * @param string $bookingReference
     */
    public function setBookingReference($bookingReference) {
        if ($bookingReference == '') {
            throw new \Hex\Domain\DomainException("Booking Reference cannot be empty");
        }
        
        $this->bookingReference = $bookingReference;
        
        $this->raise(new \Hex\Domain\Events\CustomerDocumentAddedEvent($this));
        
        return $this;
    }
    
    public function getBookingReference() {
        return $this->bookingReference;
    }

}

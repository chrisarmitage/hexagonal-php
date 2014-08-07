<?php

namespace Hex\Domain;

class CustomerDocument
{
    protected $bookingReference;
    
    /**
     * Constraint: A booking reference must be present
     * 
     * @param string $bookingReference
     */
    public function setBookingReference($bookingReference) {
        if ($bookingReference == '') {
            throw new Hex\Domain\DomainException("Booking Reference cannot be empty");
        }
        
        $this->bookingReference = $bookingReference;
        
        return $this;
    }
}

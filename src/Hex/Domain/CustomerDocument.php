<?php

namespace Hex\Domain;

class CustomerDocument
{
    use \Hex\Domain\Eventable;
    
    protected $bookingReference;
    
    protected $documentType;
    
    protected $documentPath;
    
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

    public function setDocumentType($documentType) {
        $this->documentType = $documentType;
        return $this;
    }

    public function setDocumentPath($documentPath) {
        $this->documentPath = $documentPath;
        return $this;
    }

        
    
    public function getDocumentType() {
        return $this->documentType;
    }

    public function getDocumentPath() {
        return $this->documentPath;
    }
        
    public function getBookingReference() {
        return $this->bookingReference;
    }

}

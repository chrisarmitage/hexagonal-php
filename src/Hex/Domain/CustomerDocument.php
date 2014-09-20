<?php

namespace Hex\Domain;

class CustomerDocument
{
    use \Hex\Domain\Eventable;
    
    protected $bookingReference;
    
    protected $documentType;
    
    protected $documentPath;
    
    public function __construct($bookingReference, $documentType, $documentPath) {
        // Constraint: A booking reference must be present
        if (empty($bookingReference)) {
            throw new \Hex\Domain\DomainException("Booking Reference cannot be empty");
        }
        
        // Constraint: A document must be present
        if (empty($documentType)) {
            throw new \Hex\Domain\DomainException("Document Type cannot be empty");
        }
        
        // Constraint: A document path must be present
        if (empty($documentPath)) {
            throw new \Hex\Domain\DomainException("Document Path cannot be empty");
        }
        
        $this->bookingReference = $bookingReference;
        $this->documentType = $documentType;
        $this->documentPath = $documentPath;
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

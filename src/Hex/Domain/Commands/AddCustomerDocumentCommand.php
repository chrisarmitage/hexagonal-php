<?php

namespace Hex\Domain\Commands;

class AddCustomerDocumentCommand
{
    protected $bookingReference;
    
    protected $documentType;
    
    protected $documentPath;
    
    public function __construct($bookingReference, $documentType, $documentPath) {
        $this->bookingReference = $bookingReference;
        $this->documentType = $documentType;
        $this->documentPath = $documentPath;
    }
    
    public function getBookingReference() {
        return $this->bookingReference;
    }

    public function getDocumentType() {
        return $this->documentType;
    }

    public function getDocumentPath() {
        return $this->documentPath;
    }

}
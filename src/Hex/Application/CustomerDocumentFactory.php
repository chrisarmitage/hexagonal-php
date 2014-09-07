<?php

namespace Hex\Application;

use \Hex\Domain\CustomerDocument as CustomerDocument;

class CustomerDocumentFactory
{
    public function make($customerDocumentData) {
        $customerDocument = new CustomerDocument();
        
        $customerDocument->setBookingReference($customerDocumentData[0])
                ->setDocumentType($customerDocumentData[1])
                ->setDocumentPath($customerDocumentData[2]);
        
        return $customerDocument;
    }

}

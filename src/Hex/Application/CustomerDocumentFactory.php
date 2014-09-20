<?php

namespace Hex\Application;

use \Hex\Domain\CustomerDocument as CustomerDocument;

class CustomerDocumentFactory
{
    public function make(\StdClass $customerDocumentData) {
        $customerDocument = new CustomerDocument(
            $customerDocumentData->reference,
            $customerDocumentData->type,
            $customerDocumentData->path
        );
        
        return $customerDocument;
    }
}

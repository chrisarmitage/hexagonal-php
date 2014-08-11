<?php

namespace Hex\Application;

use \Hex\Domain\CustomerDocument as Document;

class CustomerDocumentStorage
{
    public function addToFolder(Document $customerDocument) {
        $sourceFilename = $customerDocument->getDocumentPath();
        
        $targetFilename = str_replace('/tmp', "/storage/{$customerDocument->getBookingReference()}", $sourceFilename);
        
        echo "Moving {$sourceFilename} to {$targetFilename}<br />";
    }
}
<?php

namespace Hex\Application;

use \Hex\Domain\CustomerDocument as Document;

class CustomerDocumentStorage
{
    protected $fileStorageEngine;
    
    public function __construct(\Gaufrette\Filesystem $fileStorageEngine) {
        $this->fileStorageEngine = $fileStorageEngine;
    }

    public function addToFolder(Document $customerDocument) {
        $sourceFilename = $customerDocument->getDocumentPath();
        
        // Don't actually gen the PDF yet
        // $targetFilename = str_replace('/tmp', "/storage/{$customerDocument->getBookingReference()}", $sourceFilename);
        
        $contents = "Invoice for {$customerDocument->getBookingReference()}\n";
        $this->fileStorageEngine->write("{$customerDocument->getBookingReference()}-invoice.txt", $contents, true);
        
        // echo "Moving {$sourceFilename} to {$targetFilename}<br />";
    }
}

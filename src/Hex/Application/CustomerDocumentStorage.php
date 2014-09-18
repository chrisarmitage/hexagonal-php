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
        
        // Dirty way of geting the filename
        $paths = explode('/', $sourceFilename);
        $fileName = array_pop($paths);
        
        $contents = "Invoice for {$customerDocument->getBookingReference()}\n";
        $this->fileStorageEngine->write("{$customerDocument->getBookingReference()}-{$fileName}", $contents, true);
        
        // echo "Moving {$sourceFilename} to {$targetFilename}<br />";
    }
}

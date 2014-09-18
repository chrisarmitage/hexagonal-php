<?php

namespace Hex\Application;

use \Hex\Domain\CustomerDocument as Document;

class CustomerDocumentStorage
{
    protected $fileStorageEngine;
    
    public function __construct(\Gaufrette\Filesystem $fileStorageEngine) {
        $this->fileStorageEngine = $fileStorageEngine;
    }

    /**
     * @param \Hex\Domain\CustomerDocument $customerDocument
     * @return string The path where the document was saved
     */
    public function addToFolder(Document $customerDocument) {
        $sourceFilename = $customerDocument->getDocumentPath();
        
        // Dirty way of geting the filename
        $paths = explode('/', $sourceFilename);
        $fileName = array_pop($paths);
        $pathName = "{$customerDocument->getBookingReference()}-{$fileName}";
        
        $contents = "Invoice for {$customerDocument->getBookingReference()}\n";
        $this->fileStorageEngine->write($pathName, $contents, true);
        
        return $pathName;
    }
}

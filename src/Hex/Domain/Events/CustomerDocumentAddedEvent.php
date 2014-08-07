<?php

namespace Hex\Domain\Events;

class CustomerDocumentAddedEvent
{
    public function __construct(\Hex\Domain\CustomerDocument $customerDocument) {
        
    }
}
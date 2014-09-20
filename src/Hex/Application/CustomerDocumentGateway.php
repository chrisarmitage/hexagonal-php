<?php

namespace Hex\Application;

class CustomerDocumentGateway
{
    public function retrieveAll() {
        return \DB::select('SELECT * FROM customer_documents');
    }
}
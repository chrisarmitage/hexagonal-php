<?php

namespace Hex\Application;

class CustomerDocumentGateway
{
    public function retrieveAll() {
        return \DB::select('SELECT * FROM customer_documents');
    }
    
    public function persist($data) {
        return \DB::insert(
            'INSERT INTO customer_documents (reference, type, path) values (:reference, :type, :path)',
            $data
        );
    }
}

<?php

namespace Hex\Application;

class CustomerGateway
{
    public function retrieveAll() {
        return \DB::select('SELECT * FROM customers');
    }
}

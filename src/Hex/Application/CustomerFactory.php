<?php

namespace Hex\Application;

use \Hex\Domain\Customer as Customer;

class CustomerFactory
{
    public function make($customerData) {
        $customer = new Customer(
            $customerData->id,
            $customerData->reference,
            $customerData->name,
            $customerData->category
        );
        
        return $customer;
    }
}

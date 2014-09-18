<?php

namespace Hex\Application;

class CustomerRepository
{
    protected $gateway;
    
    protected $factory;
    
    public function __construct(
            \Hex\Application\CustomerGateway $gateway,
            \Hex\Application\CustomerFactory $factory
            ) {
        $this->gateway = $gateway;
        $this->factory = $factory;
    }
    
    public function add() {
        throw new ApplicationException('Method not implemented');
    }
    
    public function findByCustomerDocumentID($id) {
        return $this->findAll()[$id];
    }
    
    public function findAll() {
        $allCustomerData = $this->gateway->retrieveAll();
        $customers = array();
        foreach ($allCustomerData as $customerData) {
            $customers[] = $this->factory->make($customerData);
        }
        return $customers;
    }
}

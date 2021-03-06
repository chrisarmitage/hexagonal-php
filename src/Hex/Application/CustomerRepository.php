<?php

namespace Hex\Application;

use \Hex\Domain\Customer as Customer;

class CustomerRepository extends ARepository
{   
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
    
    public function findByCustomerId($id) {
        return array_filter(
            $this->findAll(),
            function (Customer $customer) use ($id) {
                return $customer->getId() == $id;
            }
        );
    }
    
    public function findByCategory($category) {
        return array_values(
            array_filter(
                $this->findAll(),
                function (Customer $customer) use ($category) {
                    return $customer->getCategory() == $category;
                }
            )
        );
    }
    
    public function findByReference($reference) {
        return array_values(
            array_filter(
                $this->findAll(),
                function (Customer $customer) use ($reference) {
                    return $customer->getReference() == $reference;
                }
            )
        );
    }
}

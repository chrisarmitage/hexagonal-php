<?php

namespace Hex\Application;

abstract class ARepository
{
    protected $gateway;
    
    protected $factory;
    
    public function findAll() {
        $allData = $this->gateway->retrieveAll();
        $objects = array();
        foreach ($allData as $data) {
            $objects[] = $this->factory->make($data);
        }
        return $objects;
    }
}

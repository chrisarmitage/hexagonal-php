<?php

namespace Hex\Domain;

class Customer
{
    use \Hex\Domain\Eventable;
    
    protected $id;
    
    protected $reference;
    
    protected $name;
    
    protected $category;

    public function __construct($id, $reference, $name, $category) {
        $this->id = $id;
        $this->reference = $reference;
        $this->name = $name;
        $this->category = $category;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getReference() {
        return $this->reference;
    }

    public function getName() {
        return $this->name;
    }

    public function getCategory() {
        return $this->category;
    }
}

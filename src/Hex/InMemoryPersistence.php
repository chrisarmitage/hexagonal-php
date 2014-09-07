<?php

namespace Hex;

class InMemoryPersistence
{
    protected $data = array();
    
    public function persist($data) {
        $this->data[] = $data;
        return count($this->data) - 1;
    }
    
    public function retrieve($id) {
        return $this->data[$id];
    }
    
    public function retrieveAll() {
        return $this->data;
    }
}

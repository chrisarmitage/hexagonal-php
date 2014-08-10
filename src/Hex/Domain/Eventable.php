<?php

namespace Hex\Domain;

trait Eventable
{
    protected $queuedEvents = [];
    
    public function raise($event) {
        $this->queuedEvents[] = $event;
    }
    
    public function flushEvents() {
        $events = $this->queuedEvents;
        $this->queuedEvents = [];
        
        return $events;
    }
}
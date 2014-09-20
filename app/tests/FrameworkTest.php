<?php

use \Mockery as M;

class FrameworkTest extends TestCase
{
    public function tearDown()
    {
        M::close();
    }
    
    public function testBasicExample()
    {
        $this->client->request('GET', '/');

        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testCustomersIndex() {
        $customerRepository = M::mock('\Hex\Application\CustomerRepository');
        $customerRepository
            ->shouldReceive('findAll')
            ->once()
            ->andReturn(array());
        
        $this->app->instance('Hex\Application\CustomerRepository', $customerRepository);
        
        $this->get('customers/index');
        
        $this->assertViewHas('customers');
    }
    
    public function testAddInvoices() {
        $customer = M::mock('\Hex\Domain\Customer');
        $customer->shouldReceive('getName')
            ->andReturn('Cust Name');
        $customer->shouldReceive('getReference')
            ->andReturn('Ref');
        
        $customerRepository = M::mock('\Hex\Application\CustomerRepository');
        $customerRepository
            ->shouldReceive('findAll')
            ->once()
            ->andReturn(array($customer));
        $this->app->instance('Hex\Application\CustomerRepository', $customerRepository);
        
        $commandBus = M::mock('\Hex\Application\SimpleCommandBus');
        $commandBus->shouldReceive('execute')
            ->once();
        $this->app->instance('Hex\Application\SimpleCommandBus', $commandBus);
        
        $dispatcher = M::mock('\Hex\Application\Dispatcher');
        $dispatcher->shouldReceive('dispatch')
            ->once();
        $this->app->instance('Hex\Application\Dispatcher', $dispatcher);
        
        $this->get('addInvoicesToAllCustomers');
    }
    
    public function testAddNotices() {
        $customer = M::mock('\Hex\Domain\Customer');
        $customer->shouldReceive('getName')
            ->andReturn('Cust Name');
        $customer->shouldReceive('getReference')
            ->andReturn('Ref');
        
        $customerRepository = M::mock('\Hex\Application\CustomerRepository');
        $customerRepository
            ->shouldReceive('findByCategory')
            ->once()
            ->with('CAT')
            ->andReturn(array($customer));
        $this->app->instance('Hex\Application\CustomerRepository', $customerRepository);
        
        $commandBus = M::mock('\Hex\Application\SimpleCommandBus');
        $commandBus->shouldReceive('execute')
            ->once();
        $this->app->instance('Hex\Application\SimpleCommandBus', $commandBus);
        
        $dispatcher = M::mock('\Hex\Application\Dispatcher');
        $dispatcher->shouldReceive('dispatch')
            ->once();
        $this->app->instance('Hex\Application\Dispatcher', $dispatcher);
        
        $this->get('addNoticesByCategory/CAT');
    }
}

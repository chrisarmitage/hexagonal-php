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

    public function testCustomerView() {
        $customer = new \Hex\Domain\Customer('1', 'Ref', 'Cust Name', 'Cat');
        $documents = array(
            new \Hex\Domain\CustomerDocument('B1', '1', 'tmp/tmp1.pdf'),
            new \Hex\Domain\CustomerDocument('B1', '2', 'tmp/tmp2.pdf'),
        );
        $customerRepository = M::mock('\Hex\Application\CustomerRepository');
        $customerRepository
            ->shouldReceive('findByReference')
            ->once()
            ->with('1')
            ->andReturn(array($customer));
        $this->app->instance('Hex\Application\CustomerRepository', $customerRepository);
        
        $customerDocumentRepository = M::mock('\Hex\Application\CustomerDocumentRepository');
        $customerDocumentRepository
            ->shouldReceive('findByReference')
            ->once()
            ->with('1')
            ->andReturn($documents);
        $this->app->instance('Hex\Application\CustomerDocumentRepository', $customerDocumentRepository);
        
        $this->get('customers/view/1');
        
        $this->assertViewHas('customer');
        $this->assertViewHas('customerDocuments');
    }
}

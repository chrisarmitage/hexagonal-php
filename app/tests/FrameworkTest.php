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
        $crawler = $this->client->request('GET', '/');

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
}

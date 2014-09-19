<?php

use \Mockery as M;

class CustomerRepositoryTest extends PHPUnit_Framework_Testcase
{
    protected function tearDown() {
        M::close();
    }
    
    public function testClassIsAvailable() {
        $customerRepository = new \Hex\Application\CustomerRepository(
            M::mock('\Hex\Application\CustomerGateway'),
            M::mock('\Hex\Application\CustomerFactory')
        );
        
        $this->assertNotNull($customerRepository);
    }
    
    public function testGatewayAndFactoryAreCalled() {
        $customerData = array(
            'id' => '1',
            'name' => 'Cust Name',
            'reference' => 'Ref',
            'category' => 'Cat',
        );
        $customer = json_decode(json_encode($customerData));
        
        $gateway = M::mock('\Hex\Application\CustomerGateway');
        $gateway->shouldReceive('retrieveAll')
            ->once()
            ->andReturn(array($customerData));
        
        $factory = M::mock('\Hex\Application\CustomerFactory');
        $factory->shouldReceive('make')
            ->once()
            ->with($customerData)
            ->andReturn($customer);
        
        $customerRepository = new \Hex\Application\CustomerRepository($gateway, $factory);
        
        $allCustomers = $customerRepository->findAll();
        
        $this->assertEquals(
            $customer,
            $allCustomers[0]
            );
    }
    
    public function testCanFindById() {
        $customerData = array(
            array(
                'id' => '1',
                'name' => 'Cust Name',
                'reference' => 'Ref',
                'category' => 'Cat',
            ),
            array(
                'id' => '2',
                'name' => 'Cust Name',
                'reference' => 'Ref',
                'category' => 'Cat',
            ),
        );
        $customer1 = M::mock('\Hex\Domain\Customer');
        $customer1->shouldReceive('getId')
            ->andReturn(1);
        $customer2 = M::mock('\Hex\Domain\Customer');
        $customer2->shouldReceive('getId')
            ->andReturn(2);
        
        $gateway = M::mock('\Hex\Application\CustomerGateway');
        $gateway->shouldReceive('retrieveAll')
            ->once()
            ->andReturn($customerData);
        
        $factory = M::mock('\Hex\Application\CustomerFactory');
        $factory->shouldReceive('make')
            ->once()
            ->with($customerData[0])
            ->andReturn($customer1);
        $factory->shouldReceive('make')
            ->once()
            ->with($customerData[1])
            ->andReturn($customer2);
        
        $customerRepository = new \Hex\Application\CustomerRepository($gateway, $factory);
        
        $foundCustomers = $customerRepository->findByCustomerId(1);
        
        $this->assertCount(1, $foundCustomers);
        $this->assertEquals(
            1,
            $foundCustomers[0]->getId()
            );
    }
    
    public function testCanFindByCategory() {
        $customerData = array(
            array(
                'id' => '1',
                'name' => 'Cust Name',
                'reference' => 'Ref',
                'category' => 'Cat',
            ),
            array(
                'id' => '2',
                'name' => 'Cust Name',
                'reference' => 'Ref',
                'category' => 'Cat',
            ),
        );
        $customer1 = M::mock('\Hex\Domain\Customer');
        $customer1->shouldReceive('getCategory')
            ->andReturn('Cat');
        $customer2 = M::mock('\Hex\Domain\Customer');
        $customer2->shouldReceive('getCategory')
            ->andReturn('Ego');
        
        $gateway = M::mock('\Hex\Application\CustomerGateway');
        $gateway->shouldReceive('retrieveAll')
            ->andReturn($customerData);
        
        $factory = M::mock('\Hex\Application\CustomerFactory');
        $factory->shouldReceive('make')
            ->with($customerData[0])
            ->andReturn($customer1);
        $factory->shouldReceive('make')
            ->with($customerData[1])
            ->andReturn($customer2);
        
        $customerRepository = new \Hex\Application\CustomerRepository($gateway, $factory);
        
        $foundCustomers = $customerRepository->findByCategory('Cat');
        $this->assertCount(1, $foundCustomers);
        $this->assertEquals(
            'Cat',
            $foundCustomers[0]->getCategory()
            );
        
        $foundCustomers = $customerRepository->findByCategory('Ego');
        $this->assertCount(1, $foundCustomers);
        $this->assertEquals(
            'Ego',
            $foundCustomers[1]->getCategory()
            );
    }
}

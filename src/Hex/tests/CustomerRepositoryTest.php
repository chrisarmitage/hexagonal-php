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
    
    protected function setUp() {
        $customerData = json_decode(json_encode(array(
            array(
                'id' => '1',
                'name' => 'Cust Name',
                'reference' => 'Ref1',
                'category' => 'Cat1',
            ),
            array(
                'id' => '2',
                'name' => 'Cust Name',
                'reference' => 'Ref2',
                'category' => 'Cat2',
            ),
            array(
                'id' => '3',
                'name' => 'Cust Name',
                'reference' => 'Ref3',
                'category' => 'Cat2',
            ),
        )));
        
        foreach ($customerData as $key => $data) {
            $customer[$key] = M::mock('\Hex\Domain\Customer');
            $customer[$key]->shouldReceive('getId')
                ->andReturn($customerData[$key]->id);
            $customer[$key]->shouldReceive('getReference')
                ->andReturn($customerData[$key]->reference);
            $customer[$key]->shouldReceive('getCategory')
                ->andReturn($customerData[$key]->category);
        }
        
        $gateway = M::mock('\Hex\Application\CustomerGateway');
        $gateway->shouldReceive('retrieveAll')
            ->andReturn($customerData);
        
        $factory = M::mock('\Hex\Application\CustomerFactory');
        foreach ($customerData as $key => $data) {
            $factory->shouldReceive('make')
                ->with($customerData[$key])
                ->andReturn($customer[$key]);
        }
        
        $this->mockRepository = new \Hex\Application\CustomerRepository($gateway, $factory);
    }
    
    public function testCanFindCustomerById() {
        $foundCustomers = $this->mockRepository->findByCustomerId(1);
        
        $this->assertCount(1, $foundCustomers);
        $this->assertEquals(
            1,
            $foundCustomers[0]->getId()
            );
    }
    
    public function testCanFindCustomerByReference() {
        $foundCustomers = $this->mockRepository->findByReference('Ref2');
        
        $this->assertCount(1, $foundCustomers);
        $this->assertEquals(
            'Ref2',
            $foundCustomers[0]->getReference()
            );
    }
    
    public function testCanFindSingleCustomerByCategory() {
        $foundCustomers = $this->mockRepository->findByCategory('Cat1');
        
        $this->assertCount(1, $foundCustomers);
        $this->assertEquals(
            'Cat1',
            $foundCustomers[0]->getCategory()
            );
    }
    
    public function testCanFindMultipleCustomersByCategory() {
        $foundCustomers = $this->mockRepository->findByCategory('Cat2');
        
        $this->assertCount(2, $foundCustomers);
        $this->assertEquals(
            'Cat2',
            $foundCustomers[0]->getCategory()
            );
        $this->assertEquals(
            'Cat2',
            $foundCustomers[1]->getCategory()
            );
    }
}

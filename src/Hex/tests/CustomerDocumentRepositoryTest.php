<?php

namespace Hex\Tests;

use \Mockery as M;

class CustomerDocumentRepositoryTest extends \PHPUnit_Framework_Testcase
{
    protected $mockRepository;
    
    protected function tearDown() {
        M::close();
    }
    
    public function testClassIsAvailable() {
        $customerDocumentRepository = new \Hex\Application\CustomerDocumentRepository(
            M::mock('\Hex\Application\CustomerDocumentGateway'),
            M::mock('\Hex\Application\CustomerDocumentFactory')
        );
        
        $this->assertNotNull($customerDocumentRepository);
    }
    
    protected function setUp() {
        $customerDocumentData = json_decode(
            json_encode(
                array(
                    array(
                        'reference' => 'Ref1',
                        'type' => '1',
                        'path' => '/tmp/tmp.pdf',
                    ),
                    array(
                        'reference' => 'Ref2',
                        'type' => '2',
                        'path' => '/tmp/tmp.pdf',
                    ),
                    array(
                        'reference' => 'Ref2',
                        'type' => '2',
                        'path' => '/tmp/tmp.pdf',
                    ),
                )
            )
        );
        
        foreach ($customerDocumentData as $key => $data) {
            $customerDocument[$key] = M::mock('\Hex\Domain\CustomerDocument');
            $customerDocument[$key]->shouldReceive('getBookingReference')
                ->andReturn($customerDocumentData[$key]->reference);
            $customerDocument[$key]->shouldReceive('getDocumentType')
                ->andReturn($customerDocumentData[$key]->type);
        }
        
        $gateway = M::mock('\Hex\Application\CustomerDocumentGateway');
        $gateway->shouldReceive('retrieveAll')
            ->andReturn($customerDocumentData);
        
        $factory = M::mock('\Hex\Application\CustomerDocumentFactory');
        foreach ($customerDocumentData as $key => $data) {
            $factory->shouldReceive('make')
                ->with($customerDocumentData[$key])
                ->andReturn($customerDocument[$key]);
        }
        
        $this->mockRepository = new \Hex\Application\CustomerDocumentRepository($gateway, $factory);
    }
    
    public function testCanFindOneDocumentByReference() {
        $foundCustomerDocuments = $this->mockRepository->findByReference('Ref1');
        $this->assertCount(1, $foundCustomerDocuments);
        $this->assertEquals(
            'Ref1',
            $foundCustomerDocuments[0]->getBookingReference()
        );
    }
    
    public function testCanFindMultipleDocumentsByReference() {
        $foundCustomerDocuments = $this->mockRepository->findByReference('Ref2');
        $this->assertCount(2, $foundCustomerDocuments);
        $this->assertEquals(
            'Ref2',
            $foundCustomerDocuments[0]->getBookingReference()
        );
    }
    
    public function testCanFindOneDocumentByType() {
        $foundCustomerDocuments = $this->mockRepository->findByDocumentType('1');
        $this->assertCount(1, $foundCustomerDocuments);
        $this->assertEquals(
            '1',
            $foundCustomerDocuments[0]->getDocumentType()
        );
    }
    
    public function testCanFindMultipleDocumentsByType() {
        $foundCustomerDocuments = $this->mockRepository->findByDocumentType('2');
        $this->assertCount(2, $foundCustomerDocuments);
        $this->assertEquals(
            '2',
            $foundCustomerDocuments[0]->getDocumentType()
        );
    }
}

<?php

class CustomerDocumentTest extends PHPUnit_Framework_Testcase
{
    public function testClassIsAvailable() {
        $customerDocument = new \Hex\Domain\CustomerDocument();
        
        $this->assertNotNull($customerDocument);
    }
    
    public function testAcceptsAValidBookingReference() {
        $customerDocument = new \Hex\Domain\CustomerDocument();
        
        $customerDocument->setBookingReference('ValidReference');
        
        $this->assertEquals(
                'ValidReference',
                $customerDocument->getBookingReference()
                );
    }
    
    /**
     * @expectedException Hex\Domain\DomainException
     * @expectedExceptionMessage Booking Reference cannot be empty
     */
    public function testThrowsDomainExceptionOnInvalidBookingReference() {
        $customerDocument = new \Hex\Domain\CustomerDocument();
        
        $customerDocument->setBookingReference('');
    }
}

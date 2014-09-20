<?php

class CustomerDocumentTest extends PHPUnit_Framework_Testcase
{
    public function testClassIsAvailable() {
        $customerDocument = new \Hex\Domain\CustomerDocument('1', '2', '3');
        
        $this->assertNotNull($customerDocument);
    }
    
    public function testAcceptsValidData() {
        $customerDocument = new \Hex\Domain\CustomerDocument('Reference', 'Type', 'Path');
        
        $this->assertEquals(
            'Reference',
            $customerDocument->getBookingReference()
        );
        
        $this->assertEquals(
            'Type',
            $customerDocument->getDocumentType()
        );
        
        $this->assertEquals(
            'Path',
            $customerDocument->getDocumentPath()
        );
    }
    
    /**
     * @expectedException Hex\Domain\DomainException
     * @expectedExceptionMessage Booking Reference cannot be empty
     */
    public function testThrowsDomainExceptionOnInvalidBookingReference() {
        $customerDocument = new \Hex\Domain\CustomerDocument('', '2', '3');
        
        // Never run, used to supress `Unused variable` warnings
        $this->assertNull($customerDocument);
    }
    
    /**
     * @expectedException Hex\Domain\DomainException
     * @expectedExceptionMessage Document Type cannot be empty
     */
    public function testThrowsDomainExceptionOnInvalidDocumentType() {
        $customerDocument = new \Hex\Domain\CustomerDocument('1', '', '3');
        
        // Never run, used to supress `Unused variable` warnings
        $this->assertNull($customerDocument);
    }
    
    /**
     * @expectedException Hex\Domain\DomainException
     * @expectedExceptionMessage Document Path cannot be empty
     */
    public function testThrowsDomainExceptionOnInvalidDocumentPath() {
        $customerDocument = new \Hex\Domain\CustomerDocument('1', '2', '');
        
        // Never run, used to supress `Unused variable` warnings
        $this->assertNull($customerDocument);
    }
}

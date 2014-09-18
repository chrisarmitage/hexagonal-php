<?php

class HomeController extends BaseController
{
    public function showWelcome() {
        return "EOL";
    }
    
    public function __construct(
            \Hex\Application\SimpleCommandBus $commandBus,
            \Hex\Application\Dispatcher $dispatcher) {
        $this->commandBus = $commandBus;
        $this->dispatcher = $dispatcher;
    }
    
    public function addInvoicesToAllCustomers() {
        echo "Call Started<hr />";
        
        $customerRepository = new \Hex\Application\CustomerRepository(
            new \Hex\Application\CustomerGateway(), 
            new \Hex\Application\CustomerFactory()
        );
        
        $allCustomers = $customerRepository->findAll();
        
        $documentType = 1;
        // Use a PDF generator
        $documentPath = '/tmp/Invoice.pdf';
        
        try {
            foreach ($allCustomers as $customer) {
                echo "<strong>Adding doc for {$customer->getName()}</strong></br>";
                $addCustomerDocumentCommand = new \Hex\Application\Commands\AddCustomerDocumentCommand(
                    $customer->getReference(),
                    $documentType,
                    $documentPath
                );

                $this->commandBus->execute($addCustomerDocumentCommand);
            }

        } catch (\ApplicationException $e) {
            return "Error: {$e->getMessage()}";
        }
        
        $completedEvent = new \Hex\Application\Events\AddCustomerDocumentsCompleteEvent(count($allCustomers));
        
        $this->dispatcher->dispatch(array($completedEvent));
        
        return '<hr />Call Completed</hr>';
    }
    
    public function addNoticesByCategory($category) {
        echo "Call Started<hr />";
        
        $customerRepository = new \Hex\Application\CustomerRepository(
            new \Hex\Application\CustomerGateway(), 
            new \Hex\Application\CustomerFactory()
        );
        
        $customers = $customerRepository->findByCategory($category);
        
        $documentType = 1;
        // Use a PDF generator
        $documentPath = '/tmp/Notice.pdf';
        
        try {
            foreach ($customers as $customer) {
                echo "<strong>Adding doc for {$customer->getName()}</strong></br>";
                $addCustomerDocumentCommand = new \Hex\Application\Commands\AddCustomerDocumentCommand(
                    $customer->getReference(),
                    $documentType,
                    $documentPath
                );

                $this->commandBus->execute($addCustomerDocumentCommand);
            }

        } catch (\ApplicationException $e) {
            return "Error: {$e->getMessage()}";
        }
        
        $completedEvent = new \Hex\Application\Events\AddCustomerDocumentsCompleteEvent(count($customers));
        
        $this->dispatcher->dispatch(array($completedEvent));
        
        return '<hr />Call Completed</hr>';
    }
}

<?php

use Hex\Application\ApplicationException as ApplicationException;

class HomeController extends BaseController
{
    protected $commandBus;
    protected $dispatcher;
    protected $customerRepository;
    
    public function showWelcome() {
        return View::make('hello');
    }
    
    public function __construct(
            \Hex\Application\SimpleCommandBus $commandBus,
            \Hex\Application\Dispatcher $dispatcher,
            \Hex\Application\CustomerRepository $customerRepository
        ) {
        $this->commandBus = $commandBus;
        $this->dispatcher = $dispatcher;
        $this->customerRepository = $customerRepository;
    }
    
    public function addInvoicesToAllCustomers() {
        echo "Call Started<hr />";
        
        $allCustomers = $this->customerRepository->findAll();
        
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

        } catch (ApplicationException $e) {
            return "Error: {$e->getMessage()}";
        }
        
        $completedEvent = new \Hex\Application\Events\AddCustomerDocumentsCompleteEvent(count($allCustomers));
        
        $this->dispatcher->dispatch(array($completedEvent));
        
        return '<hr />Call Completed</hr>';
    }
    
    public function addNoticesByCategory($category) {
        echo "Call Started<hr />";
        
        $customers = $this->customerRepository->findByCategory($category);
        
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

        } catch (ApplicationException $e) {
            return "Error: {$e->getMessage()}";
        }
        
        $completedEvent = new \Hex\Application\Events\AddCustomerDocumentsCompleteEvent(count($customers));
        
        $this->dispatcher->dispatch(array($completedEvent));
        
        return '<hr />Call Completed</hr>';
    }
    
    public function indexCustomers() {
        $customers = $this->customerRepository->findAll();
        
        return View::make('customers.index')
            ->with('customers', $customers);
    }
    
    public function viewCustomer($reference) {
        $customerDocumentRepository = App::make('\Hex\Application\CustomerDocumentRepository');
        $customers = $this->customerRepository->findByReference($reference);
        $customer = array_pop($customers);
        $customerDocuments = $customerDocumentRepository->findByReference($reference);
        
        return View::make('customers.view')
            ->with('customer', $customer)
            ->with('customerDocuments', $customerDocuments);
    }
}

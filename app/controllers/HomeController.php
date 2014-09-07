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
    
    public function test() {
        echo "Call Started<hr />";
        $bookingReference = 'H100';
        $documentType = 1;
        $documentPath = '/tmp/Invoice.pdf';
        
        $docsToAdd = mt_rand(4, 8);

        try {
            for ($n = 1; $n <= $docsToAdd; $n++) {
                echo "<strong>Adding doc {$n}</strong></br>";
                $addCustomerDocumentCommand = new \Hex\Application\Commands\AddCustomerDocumentCommand(
                    $bookingReference . $n, $documentType,
                    $documentPath
                );

                $this->commandBus->execute($addCustomerDocumentCommand);
            }

        } catch (\PhantomException $e) {
            return "Error: {$e->getMessage()}";
        }
        
        $completedEvent = new \Hex\Application\Events\AddCustomerDocumentsCompleteEvent($docsToAdd);
        
        $this->dispatcher->dispatch(array($completedEvent));
        
        return '<hr />Call Completed</hr>';
    }
}

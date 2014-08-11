<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
        return "EOL";
        //return View::make('hello');
	}
    
    public function __construct(\Hex\Application\SimpleCommandBus $commandBus) {
        $this->commandBus = $commandBus;
    }
    
    public function test() {
        echo "Call Started<hr />";
        $bookingReference = 'H100';
        $documentType = 1;
        $documentPath = '/tmp/Invoice.pdf';

        try {
            for ($n = 1; $n <=4; $n++) {
                echo "<strong>Adding doc {$n}</strong></br>";
                $addCustomerDocumentCommand = new \Hex\Application\Commands\AddCustomerDocumentCommand(
                        $bookingReference . $n, $documentType, $documentPath);

                $this->commandBus->execute($addCustomerDocumentCommand);
            }

        } catch (\PhantomException $e) {
            return "Error: {$e->getMessage()}";
        }
        
        return '<hr />Call Completed</hr>';
    }

}

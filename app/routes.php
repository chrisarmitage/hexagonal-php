<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('test', 'HomeController@test');

Event::listen('customer_document.added', function($event)
{
    echo "&nbsp;&nbsp;<strong>Event Fired</strong>: Document added for Booking {$event->getCustomerDocument()->getBookingReference()} (type {$event->getCustomerDocument()->getDocumentType()}, at {$event->getCustomerDocument()->getDocumentPath()})<br />";
});

Event::listen('customer_folder.updated', function($event)
{
    echo "&nbsp;&nbsp;<strong>Event Fired</strong>: Customer folder updated {$event->getBookingReference()}<br />";
});

Event::listen('add_customer_documents.complete', function($event)
{
    echo "&nbsp;&nbsp;<strong>Event Fired</strong>: Add Customer Documents completed - {$event->getNumberOfDocumentsAdded()} added<br />";
});

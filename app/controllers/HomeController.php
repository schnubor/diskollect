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

		/*Mail::send('emails.auth.test', array('name' => 'Chris'), function($message){
			$message->to('schnuppser@gmail.com', 'Christian Korndörfer')->subject('Test email');
		});*/

		return View::make('welcome');
	}

}

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
		$users = User::all()->count();
		$vinyls = Vinyl::all()->count();
		$latestVinyls = Vinyl::orderBy('created_at', 'DESC')->take(6)->get();

		return View::make('welcome')
			->with('users', $users)
			->with('vinyls', $vinyls)
			->with('latestVinyls', $latestVinyls);
  }

}

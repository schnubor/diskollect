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
		return View::make('welcome');
  }

  public function oauthTest()
  {
  	// build guzzle client to make requests
      $client = new GuzzleHttp\Client([
          'base_url' => 'http://api.discogs.com',
          'defaults' => [
              'headers' => ['User-Agent' => 'Diskollect/1.0 +http://diskollect.com' ], // specify recognizable user-agent
              'auth'    => 'oauth',
          ],
      ]);

      // attach oauth subscriber to grab images
      $client->getEmitter()->attach(new GuzzleHttp\Subscriber\Oauth\Oauth1([
          'consumer_key'    => $_ENV['DC_CONSUMER_KEY'],
          'consumer_secret' => $_ENV['DC_CONSUMER_SECRET'],
          'token'           => Auth::user()->discogs_access_token,
          'token_secret'    => Auth::user()->discogs_access_token_secret,
      ]));

      $response = $client->get('/oauth/identity')->json();
      //$response = $client->get('/images/1')->json();
      dd($response);

      // make calls
      $results = $client->get('/database/search', [ 'query' => [
          'q'    => 'Justin Bieber',
          'type' => 'artist',
      ]])->json();

      // get image body
      $rawImage = $client
          ->get('http://path-to-restricted-discogs-cover')
          ->getBody();
  }

}

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
		// oAuth to Discogs to enable services
		$client = new oauth_client_class;
		$client->debug = false;
        $client->debug_http = true;
        $client->server = 'Discogs';
        $client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].
            dirname(strtok($_SERVER['REQUEST_URI'],'?'));

        $client->client_id = 'iLHTUYXHgeToxDaAWpAX'; $application_line = __LINE__;
        $client->client_secret = 'dPaSaHBIyyNgNqZuPFPpBTCentqzPxPj';

        if(strlen($client->client_id) == 0
        || strlen($client->client_secret) == 0)
            die('Please go to Discogs Developers page http://www.discogs.com/applications/edit , '.
                'create an application, and in the line '.$application_line.
                ' set the client_id to Consumer key and client_secret with Consumer secret. '.
                'The Callback URL must be '.$client->redirect_uri);

        return View::make('welcome');

        if(($success = $client->Initialize()))
        {
            if(($success = $client->Process()))
            {
                if(strlen($client->access_token))
                {
                    $success = $client->CallAPI(
                        'http://api.discogs.com/oauth/identity', 
                        'GET', array(), array('FailOnAccessError'=>true), $user);
                }
            }
            $success = $client->Finalize($success);
        }
        
        if($client->exit)
            exit;

        if($success)
        {
			return View::make('welcome');
		}
    }

}

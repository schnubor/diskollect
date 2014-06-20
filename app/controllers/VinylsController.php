<?php

class VinylsController extends \BaseController {

	/*
	| GET search form
	*/
	public function getSearch()
	{
		$user = User::find(Auth::user()->id);
		// Check if user already obtained Discogs Access Token

		if($user->discogs_access_token){
			return View::make('vinyls.search');
		}
		else{
			return View::make('vinyls.discogs');
		}
	}

	/*
	| GET Discogs oAuth Access Token
	*/
	public function oAuthDiscogs(){
		// oAuth to Discogs to enable search
		$client = new oauth_client_class;
		$client->debug = true;
    $client->debug_http = true;
    $client->server = 'Discogs';
    $client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].
        dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/discogs';

    $client->client_id = 'iLHTUYXHgeToxDaAWpAX'; $application_line = __LINE__;
    $client->client_secret = 'dPaSaHBIyyNgNqZuPFPpBTCentqzPxPj';

    if(strlen($client->client_id) == 0
    || strlen($client->client_secret) == 0)
        die('Please go to Discogs Developers page http://www.discogs.com/applications/edit , '.
            'create an application, and in the line '.$application_line.
            ' set the client_id to Consumer key and client_secret with Consumer secret. '.
            'The Callback URL must be '.$client->redirect_uri);

    if(($success = $client->Initialize()))
    {
      if(($success = $client->Process()))
      {
        if(strlen($client->access_token))
        {
          
          if($success = $client->CallAPI(
            'http://api.discogs.com/oauth/identity', 
            'GET', array(), array('FailOnAccessError'=>true), $DiscogsUser))
          {
	          $user = User::find(Auth::user()->id); // Find current user
	          $user->discogs_access_token = $client->access_token;
	          $user->discogs_access_token_secret = $client->access_token_secret;
	          $user->discogs_uri = $DiscogsUser->resource_url;

	          if(!$user->save()){
	          	return Redirect::to('/search')
	          		->with('danger-alert','Oops! Something went wrong while writing oAuth Data to the database.');
	          }
	        }
	        else{
	        	return Redirect::to('/search')
	        		->with('danger-alert','Oops! Discogs API call failed.');
	        }
        }
      }
      $success = $client->Finalize($success);
    }
    
    if($client->exit)
       exit;

    if($success)
    {
			return Redirect::to('/search')
				->with('success-alert', 'Success! You have successfully authenticated with Discogs and may now use the search.');
		}
	}

	/*
	| POST search and render results
	*/
	public function postSearch()
	{
		$validator = Validator::make(Input::all(), array(
			'artist' => 'max:50'
		));

		if($validator->fails()){
			return Redirect::to('search')
				->withErrors($validator)
				->withInput();
		}
		else{

			$artist = Input::get('artist');
			$title = Input::get('title');

			// Discogs
			$service = new \Discogs\Service();

			$resultset = $service->search(array(
		    'artist' 	=> $artist,
		    'title' 	=> $title,
		    'format' 	=> 'Vinyl'
			));

			$count = $resultset->count();
			$page = $resultset->getPagination();
			$results = $resultset->getResults();

			return View::make('vinyls.results')
				->with('artist', $artist)
				->with('title', $title)
				->with('results', $results)
				->with('count', $count)
				->with('page', $page);
		}

		return Redirect::to('search')->with('danger-alert', 'Oops! Something went wrong the search was posted.');
	}

	/*
	| GET Collection
	*/
	public function showCollection($id)
	{
		$vinyls = User::find($id)->vinyls;
		$user = User::find($id);

		$data = array('user' => $user, 'vinyls' => $vinyls);
		return View::make('vinyls.collection', $data);
	}

	/*
	| GET single vinyl
	*/
	public function showVinyl($id)
	{
		$vinyl = Vinyl::find($id);

		return View::make('vinyls.show')
			->with('vinyl', $vinyl);
	}

	/*
	| GET create Vinyl Form
	*/
	public function createVinyl()
	{
		$vinyl = Input::all();
		return View::make('vinyls.create')
			->with('vinyl', $vinyl);
	}

	/*
	| POST store Vinyl Form
	*/
	public function storeVinyl()
	{
		return 'store';
	}

}
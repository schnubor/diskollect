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
    else{
      dd($client->error);
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
			$client = Discogs\ClientFactory::factory([
        'defaults' => [
            'headers' => ['User-Agent' => 'diskollect/0.1 +http://beta.diskollect.com'],
        ]
      ]);

      $user = Auth::user();

      $oauth = new GuzzleHttp\Subscriber\Oauth\Oauth1([
        'consumer_key'    => $_ENV['DC_CONSUMER_KEY'], // from Discogs developer page
        'consumer_secret' => $_ENV['DC_CONSUMER_SECRET'], // from Discogs developer page
        'token'           => $user->discogs_access_token, // get this using a OAuth library
        'token_secret'    => $user->discogs_access_token_secret // get this using a OAuth library
      ]);
      $client->getHttpClient()->getEmitter()->attach($oauth);

			$response = $client->search([
        'artist' => $artist,
        'title' => $title,
        'format' => 'vinyl'
      ]);

      $results = [];

      foreach($response['results'] as $result){
        if($result['type'] == 'release'){
          $release = $client->getRelease([
            'id' => $result['id']
          ]);
          $release['type'] = 'release';
          array_push($results, $release);
        }
        else{ // Master
          $master = $client->getMaster([
            'id' => $result['id']
          ]);
          $master['type'] = 'master';
          array_push($results, $master);
        }
      }

			return View::make('vinyls.results')
				->with('artist', $artist)
				->with('title', $title)
				->with('results', $results);
		}

		return Redirect::to('search')->with('danger-alert', 'Oops! Something went wrong the search was posted.');
	}

	/*
	| GET Collection
	*/
	public function showCollection($id)
	{
		$vinyls = User::find($id)->vinyls()->paginate(32);
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
		$result = Input::all();
    $user = Auth::user();

    if($result){
      // Discogs
      $client = Discogs\ClientFactory::factory([
        'defaults' => [
            'headers' => ['User-Agent' => 'diskollect/0.1 +http://beta.diskollect.com'],
        ]
      ]);

      $oauth = new GuzzleHttp\Subscriber\Oauth\Oauth1([
        'consumer_key'    => $_ENV['DC_CONSUMER_KEY'], // from Discogs developer page
        'consumer_secret' => $_ENV['DC_CONSUMER_SECRET'], // from Discogs developer page
        'token'           => $user->discogs_access_token, // get this using a OAuth library
        'token_secret'    => $user->discogs_access_token_secret // get this using a OAuth library
      ]);
      $client->getHttpClient()->getEmitter()->attach($oauth);

      if($result['type'] == 'release'){
        $vinyl = $client->getRelease([
          'id' => $result['id']
        ]);
      }
      else{
        $vinyl = $client->getMaster([
          'id' => $result['id']
        ]);
      }

      $vinyl['type'] = $result['type'];

  		return View::make('vinyls.create') // create from search
  			->with('vinyl', $vinyl)
        ->with('user', $user)
        ->with('search', true);
    }
    else{
      return View::make('vinyls.create') // create manually
        ->with('user', $user)
        ->with('search', false);
    }
	}

  /*
  | GET edit Vinyl Form
  */
  public function editVinyl($id){
    $vinyl = Vinyl::find($id);

    return View::make('vinyls.edit')
      ->with('vinyl', $vinyl);
  }

  /*
  | UPDATE Vinyl
  */
  public function updateVinyl($id){
    $validator = Validator::make(Input::all(), array(
      'artist' => 'required',
      'title' => 'required',
      'price' => 'required'
    ));

    if($validator->fails()){
      return Redirect::back()
        ->with('danger-alert', 'Oops! Artist, Title and Price are required.');
    }
    else{
      // Check if price contains comma
      $price = e(Input::get('price'));
      if(!is_numeric($price)){
        $price = str_replace(',','.',$price);
      }

      if(!is_numeric($price)){
        return Redirect::route('get-edit-vinyl')
          ->withInput()
          ->with('danger-alert', 'Oops! Price needs to be a valid number.');
      } 

      // Update vinyl
      $vinyl = Vinyl::find($id);

      $vinyl->artwork = input::get('artwork');
      $vinyl->artist = Input::get('artist');
      $vinyl->title = Input::get('title');
      $vinyl->label = input::get('label');
      $vinyl->genre = input::get('genre');
      $vinyl->price = $price;
      $vinyl->videos = input::get('videos');
      $vinyl->tracklist = input::get('tracklist');
      $vinyl->country = input::get('country');
      $vinyl->size = input::get('size');
      $vinyl->count = input::get('count');
      $vinyl->color = input::get('color');
      $vinyl->type = input::get('type');
      $vinyl->releasedate = input::get('year');
      $vinyl->notes = input::get('notes');

      if($vinyl->save()){
        return Redirect::route('get-collection', Auth::user()->id )
          ->with('success-alert', 'Success! <strong>' . Input::get('artist') . ' - ' . Input::get('title') . '</strong> was updated.');
      }
    }

    return Redirect::route('get-edit-vinyl')
      ->withInput()
      ->with('danger-alert', 'Oops! The vinyl could not be updated.');
  }

	/*
	| POST store Vinyl Form
	*/
	public function storeVinyl()
	{
    $validator = Validator::make(Input::all(), array(
      'artist' => 'required',
      'title' => 'required',
      'price' => 'required'
    ));

    if($validator->fails()){
      return Redirect::back()
        ->with('danger-alert', 'Oops! Artist, Title and Price are required.');
    }
    else{

      // Check if price contains comma
      $price = e(Input::get('price'));
      if(!is_numeric($price)){
        $price = str_replace(',','.',$price);
      }

      if(!is_numeric($price)){
        return Redirect::route('get-create-vinyl-search')
          ->withInput()
          ->with('danger-alert', 'Oops! Price needs to be a valid number.');
      } 

      // Create vinyl
      $vinyl = Vinyl::create(array(
        'user_id' => input::get('user_id'),
        'artwork' => input::get('artwork'),
        'artist' => Input::get('artist'),
        'title' => Input::get('title'),
        'label' => input::get('label'),
        'genre' => input::get('genre'),
        'price' => $price,
        'videos' => input::get('videos'),
        'tracklist' => input::get('tracklist'),
        'country' => input::get('country'),
        'size' => input::get('size'),
        'count' => input::get('count'),
        'color' => input::get('color'),
        'type' => input::get('type'),
        'releasedate' => input::get('year'),
        'notes' => input::get('notes')
      ));

      if($vinyl){
        return Redirect::route('get-vinyl', $vinyl->id )
          ->with('success-alert', 'Success! <strong>' . Input::get('artist') . ' - ' . Input::get('title') . '</strong> is now in your collection.');
      }
    }

		return Redirect::route('get-create-vinyl-search')
      ->withInput()
      ->with('danger-alert', 'Oops! The vinyl could not be added.');
	}

  /*
  | Delete Vinyl
  */
  public function deleteVinyl($id){
    $vinyl = Vinyl::find($id);

    if($vinyl->delete()){
      return Redirect::route('get-collection', Auth::user()->id )
        ->with('info-alert', 'All done! Vinyl deleted successfully.');
    }
    else{
      return Redirect::route('get-collection', Auth::user()->id )
        ->with('danger-alert', 'Oops! Vinyl could not be deleted.');
    }
  }

}

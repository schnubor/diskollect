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
    $userAgent = 'Diskollect/1.0, +http://diskollect.com';  // specify recognizable user-agent

    $server = new \League\OAuth1\Client\Server\Discogs([
      'identifier'   => $_ENV['DC_CONSUMER_KEY'],
      'secret'       => $_ENV['DC_CONSUMER_SECRET'],
      'callback_uri' => 'http://'.$_SERVER['HTTP_HOST'].dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/discogs'
    ], null, $userAgent);

    // no temporary token? redirect then
    if ( !isset($_GET['oauth_token']) ) {
      $tempCredentials = $server->getTemporaryCredentials();
      Session::put('tempCredentials', serialize($tempCredentials));
      Session::save();
      header('Location: '.$server->getAuthorizationUrl($tempCredentials));
      $server->authorize($tempCredentials);
    }

    // ok got temporary token
    // nb: you may save it in db
    $token = $server->getTokenCredentials(
      unserialize(Session::get('tempCredentials')),
      Input::get('oauth_token'),
      Input::get('oauth_verifier')
    );

    // Discogs TEST
    $client = Discogs\ClientFactory::factory([]);

    $oauth = new GuzzleHttp\Subscriber\Oauth\Oauth1([
      'consumer_key'    => $_ENV['DC_CONSUMER_KEY'], // from Discogs developer page
      'consumer_secret' => $_ENV['DC_CONSUMER_SECRET'], // from Discogs developer page
      'token'           => $token->getIdentifier(), // get this using a OAuth library
      'token_secret'    => $token->getSecret() // get this using a OAuth library
    ]);
    $client->getHttpClient()->getEmitter()->attach($oauth);
    $identity = $client->getOAuthIdentity();

    $user = Auth::user(); // Current user
    $user->discogs_access_token = $token->getIdentifier();
    $user->discogs_access_token_secret = $token->getSecret();
    $user->discogs_uri = $identity['resource_url'];

    if($user->save()){
    	return Redirect::to('/search')
      ->with('success-alert','Succesfully authenticated with Discogs as <a href="'.$identity['resource_url'].'" target="_blank">'.$identity['username'].'</a>.');
    }
    else{
    	return Redirect::to('/search')
    		->with('danger-alert','Oops! Could not save tokens to database.');
    }

    return Redirect::to('/search')
      ->with('danger-alert','Oops! Discogs Authentication failed.');
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
      $user = Auth::user();

			// Discogs
			$client = Discogs\ClientFactory::factory([]);

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
	public function showCollection($id, $grid = 'grid', $sort = 'alphabetical')
	{
		$vinyls = User::find($id)->vinyls()->paginate(32);
		$user = User::find($id);

		$data = array('user' => $user, 'vinyls' => $vinyls, 'grid' => $grid);
		return View::make('vinyls.collection', $data);
	}

	/*
	| GET single vinyl
	*/
	public function showVinyl($id)
	{
		$vinyl = Vinyl::find($id);

    $youtube = new Youtube(array('key' => 'AIzaSyBRwXTDmN989t-MU0luj2P6dQT8PPOQNMY'));
    $sc_results = json_decode(Soundcloud::get('tracks', array('q' => $vinyl->artist, 'title' => $vinyl->title, 'limit' => 3)));
    $search_results = $youtube->search($vinyl->artist.' '.$vinyl->title);
    //dd($search_results[0]->id);
    $yt_results = [];
    foreach($search_results as $result){
      if($result->id->kind == 'youtube#playlist'){
        array_push($yt_results, array('playlistId' => $result->id->playlistId, 'videoId' => $youtube->getPlaylistItemsByPlaylistId($result->id->playlistId)[0]->contentDetails->videoId ));
      }
    }

		return View::make('vinyls.show')
			->with('vinyl', $vinyl)
      ->with('soundcloud', $sc_results)
      ->with('youtube', $yt_results);
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
      $client = Discogs\ClientFactory::factory([]);

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
      $vinyl->releasetype = input::get('releasetype');
      $vinyl->weight = input::get('weight');
      $vinyl->catno = input::get('catno');
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
        'notes' => input::get('notes'),
        'weight' => input::get('weight'),
        'catno' => input::get('catno'),
        'releasetype' => input::get('releasetype')
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

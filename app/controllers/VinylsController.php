<?php

class VinylsController extends \BaseController {

	/*
	| GET search form
	*/
	public function getSearch()
	{
		return View::make('vinyls.search');
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

      // check if discogs tokens are valid
      $identity = $client->getOAuthIdentity();

      foreach($response['results'] as $result){
        if($result['type'] == 'release'){ // Release
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

      // iTunes data
      $iTunesData = [];

      foreach($results as $result){
        $iTunesResult = ITunes::search($result['artists'][0]['name'].' '.$result['title'], array('limit' => 1));
        $iTunesResult = json_decode($iTunesResult);
        array_push($iTunesData, $iTunesResult);
      }

			return View::make('vinyls.results')
				->with('artist', $artist)
				->with('title', $title)
				->with('results', $results)
        ->with('iTunesData', $iTunesData);
		}

		return Redirect::to('search')->with('danger-alert', 'Oops! Something went wrong the search was posted.');
	}

	/*
	| GET Collection
	*/
	public function showCollection($id, $grid = 'grid', $sort = 'alphabetical')
	{
		$vinyls = User::find($id)->vinyls()->orderBy('created_at', 'DESC')->paginate(32);
		$user = User::find($id);
    $weight = $vinyls->sum('weight');
    $value = number_format(round($vinyls->sum('price'),2),2);

		$data = array('user' => $user, 'vinyls' => $vinyls, 'grid' => $grid, 'weight' => $weight, 'value' => $value);

		return View::make('vinyls.collection', $data);
	}

	/*
	| GET single vinyl
	*/
	public function showVinyl($id)
	{
		$vinyl = Vinyl::find($id);
    $tracks = Vinyl::find($id)->tracks;

    // Soundcloud
    $sc_results = json_decode(Soundcloud::get('tracks', array('q' => $vinyl->artist, 'title' => $vinyl->title, 'limit' => 3)));

    // Youtube
    $youtube = new Youtube(array('key' => 'AIzaSyBRwXTDmN989t-MU0luj2P6dQT8PPOQNMY'));

    $yt_results = [];
    foreach($tracks as $track){
      $params = [
        'q' => $vinyl->artist.' '.$track->title,
        'type'          => 'video',
        'part'          => 'id',
        'maxResults'    => 1
      ];
      array_push($yt_results, $youtube->searchAdvanced($params, false));
    }
    //dd($yt_results);
    /*if($search_results){
      foreach($search_results as $result){
        if($result->id->kind == 'youtube#playlist'){
          array_push($yt_results, array('playlistId' => $result->id->playlistId, 'videoId' => $youtube->getPlaylistItemsByPlaylistId($result->id->playlistId)[0]->contentDetails->videoId ));
        }
      }
    }*/

		return View::make('vinyls.show')
			->with('vinyl', $vinyl)
      ->with('tracks', $tracks)
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
      $artwork = $result['artwork'];

  		return View::make('vinyls.create') // create from search
  			->with('vinyl', $vinyl)
        ->with('artwork', $artwork)
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
    $tracks = Vinyl::find($id)->tracks;

    if(Auth::user()->id == $vinyl->user_id){
      return View::make('vinyls.edit')
      ->with('vinyl', $vinyl)
      ->with('tracks', $tracks);
    }
    else{
      return Redirect::route('get-vinyl',$id);
    }
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

      // Update vinyl & tracks
      $vinyl = Vinyl::find($id);
      $tracks = Vinyl::find($id)->tracks;

      $vinyl->artwork = input::get('artwork');
      $vinyl->artist = Input::get('artist');
      $vinyl->title = Input::get('title');
      $vinyl->label = input::get('label');
      $vinyl->genre = input::get('genre');
      $vinyl->price = $price;
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
        // Update Tracks
        $tracklistItems = input::get('tracklist_length');
        $newTracklistItems = input::get('tracklist_length_new');

        // Update existing Tracks
        for($i = 0; $i < $tracklistItems; $i++){
          $track = Track::find(input::get('track_'.$i.'_id'));
          $track->number = input::get('track_'.$i.'_pos');
          $track->title = input::get('track_'.$i.'_title');
          $track->duration = input::get('track_'.$i.'_duration');
          $track->save();
        }

        // Create new Tracks
        for($i = 0; $i < $newTracklistItems; $i++){
          Track::create(array(
            'vinyl_id' => $id,
            'artist_id' => 1,
            'artist' => $vinyl->artist,
            'title' => input::get('track_'.($i+$tracklistItems).'_title'),
            'number' => input::get('track_'.($i+$tracklistItems).'_pos'),
            'duration' => input::get('track_'.($i+$tracklistItems).'_duration'),
          ));
        }
        // Delete Tracks
        // ...

        return Redirect::route('get-vinyl', $vinyl->id )
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
        // Save tracks
        $tracklistItems = input::get('tracklist_length');
        for($i = 0; $i < $tracklistItems; $i++){
          Track::create(array(
            'vinyl_id' => $vinyl->id,
            'artist_id' => 1,
            'artist' => $vinyl->artist,
            'title' => input::get('track_'.$i.'_title'),
            'number' => input::get('track_'.$i.'_pos'),
            'duration' => input::get('track_'.$i.'_duration'),
          ));
        }

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

<?php

class VinylsController extends \BaseController {

	public function getSearch()
	{
		return View::make('vinyls.search');
	}

	public function postSearch()
	{
		$validator = Validator::make(Input::all(), array(
			'artist' => 'required'
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

			$results = $resultset->getResults();

			return View::make('vinyls.results')
				->with('results', $results);
		}

		return Redirect::to('search')->with('danger-alert', 'Oops! Something went wrong the search was posted.');
	}

}
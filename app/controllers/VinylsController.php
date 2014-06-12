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
		return View::make('vinyls.create');
	}

	/*
	| POST store Vinyl Form
	*/
	public function storeVinyl()
	{
		return 'store';
	}

}
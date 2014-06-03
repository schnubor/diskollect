<?php

class VinylsController extends \BaseController {

	public function getSearch()
	{

		$service = new \Discogs\Service();

		$resultset = $service->search(array(
	    'q'     => 'Meagashira',
	    'label' => 'Enzyme'
		));

		$results = $resultset->getResults();

		return $results[0]->getThumb();
	}

}
<?php

class VinylsTableSeeder extends Seeder {

	public function run()
	{
		DB::table('vinyls')->delete();

		$vinyls = array(
			array(
				'user_id' => 1,
				'artwork' => 'http://s.pixogs.com/image/R-150-4570366-1368696285-3832.jpeg',
				'artist' => 'Daft Punk',
				'title' => 'Random Access Memories',
				'label' => 'Columbia',
				'genre' => 'Electronic',
				'price' => 12.3,
				'videos' => 'https://www.youtube.com/watch?v=SRJOk7z4mws',
				'tracklist' => 'A1. Give Life Back To Music 4:35; A2. The Game Of Love 5:22; A3. Giorgio By Moroder 9:04; B1. Within 3:48; B2. Instant Crush 5:37; B3. Lose Yourself To Dance 5:53; C1. Touch 8:18; C2. Get Lucky 6:09; C3. Beyond 4:50; D1. Motherboard 5:41; D2. Fragments Of Time 4:39; D3. Doin\' It Right 4:11; D4. Contact 6:21',
				'country' => 'US',
				'size' => 12,
				'count' => 2,
				'color' => '#000000',
				'type' => 'release',
				'releasedate' => '2014-06-03 16:19:31',
				'notes' => 'mint'
			),

			array(
				'user_id' => 1,
				'artwork' => 'http://s.pixogs.com/image/R-150-2879-1236035472.jpeg',
				'artist' => 'Daft Punk',
				'title' => 'Discovery',
				'label' => 'Virgin',
				'genre' => 'Electronic',
				'price' => 15,
				'videos' => 'http://www.youtube.com/watch?v=FGBhQbmPwH8',
				'tracklist' => 'A1. One More Time; A2. Aerodynamic; A3. Digital Love; B1. Harder, Better, Faster, Stronger; B2. Crescendolls; B3. Nightvision; B4. Superheroes; C1. High Life; C2. Something About Us; C3. Voyager; C4. Veridis Quo; D1. Short Circuit; D2. Face To Face; D3. Too Long',
				'country' => 'US',
				'size' => 12,
				'count' => 2,
				'color' => '#000000',
				'type' => 'release',
				'releasedate' => '2004-06-03',
				'notes' => 'mint rare'
			),

			array(
				'user_id' => 2,
				'artwork' => 'http://s.pixogs.com/image/R-150-2879-1236035472.jpeg',
				'artist' => 'Daft Punk',
				'title' => 'Human After All',
				'label' => 'Virgin',
				'genre' => 'Electronic',
				'price' => 15,
				'videos' => 'http://www.youtube.com/watch?v=FGBhQbmPwH8',
				'tracklist' => 'A1. One More Time; A2. Aerodynamic; A3. Digital Love; B1. Harder, Better, Faster, Stronger; B2. Crescendolls; B3. Nightvision; B4. Superheroes; C1. High Life; C2. Something About Us; C3. Voyager; C4. Veridis Quo; D1. Short Circuit; D2. Face To Face; D3. Too Long',
				'country' => 'US',
				'size' => 12,
				'count' => 2,
				'color' => '#000000',
				'type' => 'release',
				'releasedate' => '2004-06-03',
				'notes' => 'mint super rare'
			),

		);

		DB::table('vinyls')->insert($vinyls);

	}

}
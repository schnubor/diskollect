<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class TracksTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 300) as $index)
		{
			Track::create([
        'vinyl_id' => $faker->numberBetween(1,30),
        'artist_id' => $faker->numberBetween(1,30),
        'number' => $faker->numberBetween(1,12),
        'title' => $faker->sentence(3),
        'artist' => $faker->name,
        'duration' => $faker->time('i:s','now')
			]);
		}
	}

}
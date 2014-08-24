<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class VinylsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 30) as $index)
		{
			Vinyl::create([
        'user_id' => $faker->numberBetween(1,3),
        'artwork' => $faker->imageUrl(600, 600, 'cats'),
        'artist' => $faker->name,
        'title' => $faker->sentence(3),
        'label' => $faker->word,
        'genre' => $faker->randomElement(['Electronic','Rock','Classical','Hip Hop','Funk','Jazz']),
        'price' => $faker->randomFloat(2,1,30),
        'weight' => $faker->numberBetween(140, 460),
        'country' => $faker->countryCode,
        'size' => $faker->randomElement([7,10,12]),
        'count' => $faker->numberBetween(1,2),
        'color' => $faker->hexcolor,
        'type' => $faker->randomElement(['release','master']),
        'releasetype' => $faker->randomElement(['EP','LP','Single','RE']),
        'notes' => $faker->sentence(5),
        'releasedate' => $faker->date('Y-m-d','now'),
        'catno' => $faker->bothify('?? ####')
			]);
		}
	}

}
<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		Vinyl::truncate();
		Track::truncate();

		//$this->call('UsersTableSeeder');
		$this->call('VinylsTableSeeder');
		$this->call('TracksTableSeeder');
	}

}

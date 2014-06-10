<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		$users = array(
			array(
				'email' => 'schnuppser@gmail.com',
				'username' => 'schnubor',
				'name' => 'Christian Korndörfer',
				'location' => 'Berlin, Germany',
				'image' => 'https://scontent-b.xx.fbcdn.net/hphotos-xfa1/t1.0-9/319966_539177582772097_855047788_n.jpg',
				'website' => 'http://www.diskollect.com',
				'description' => 'Berlin, 27',
				'password' => Hash::make('password'),
				'active' => 1,
			),

			array(
				'email' => 'korndoerfer@tape.tv',
				'username' => 'korndoerfer',
				'name' => 'Christian Korndörfer',
				'location' => 'Berlin, Germany',
				'image' => 'https://scontent-b.xx.fbcdn.net/hphotos-xfa1/t1.0-9/319966_539177582772097_855047788_n.jpg',
				'website' => 'http://www.tape.tv',
				'description' => 'Berlin, 27, tape.tv',
				'password' => Hash::make('password'),
				'active' => 1,
			)
		);

		DB::table('users')->insert($users);
	}

}
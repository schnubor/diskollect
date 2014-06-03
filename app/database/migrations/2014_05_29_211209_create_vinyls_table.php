<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVinylsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vinyls', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('artwork');
			$table->string('artist');
			$table->string('title');
			$table->string('label');
			$table->string('genre');
			$table->string('price');
			$table->string('videos');
			$table->string('tracklist');
			$table->integer('duration');
			$table->integer('size');
			$table->integer('count');
			$table->string('color');
			$table->string('releasetype');
			$table->date('releasedate');
			$table->string('notes');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vinyls');
	}

}

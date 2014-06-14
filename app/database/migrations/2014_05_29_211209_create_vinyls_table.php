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
			$table->float('price');
			$table->string('videos');
			$table->text('tracklist');
			$table->text('country');
			$table->integer('size');
			$table->integer('count');
			$table->string('color');
			$table->string('type');
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

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
			$table->string('artwork')->nullable();
			$table->string('artist');
			$table->string('title');
			$table->string('label')->nullable();
			$table->string('genre')->nullable();
			$table->float('price')->nullable();
			$table->string('videos')->nullable();
			$table->text('tracklist')->nullable();
			$table->text('country')->nullable();
			$table->integer('size');
			$table->integer('count')->nullable();
			$table->string('color');
			$table->string('type');
			$table->string('releasedate')->nullable();
			$table->string('notes')->nullable();
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

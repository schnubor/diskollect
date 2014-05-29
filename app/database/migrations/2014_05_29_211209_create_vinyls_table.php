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
			$table->string('artist');
			$table->string('title');
			$table->string('label');
			$table->date('releasedate');
			$table->string('artwork');
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

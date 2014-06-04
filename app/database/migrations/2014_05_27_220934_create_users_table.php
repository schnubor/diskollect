<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table)
		{
		    $table->increments('id');
		    $table->string('email', 50)->unique();
		    $table->string('username', 20)->unique();
		    $table->string('name', 50);
		    $table->string('website', 50);
		    $table->string('country', 50);
		    $table->string('image');
		    $table->string('description', 140);
		    $table->string('password', 60);
		    $table->string('password_temp', 60)->nullable();
		    $table->string('code', 60)->nullable();
		    $table->boolean('active');
		    $table->string('remember_token')->nullable();
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
		Schema::dropIfExists('users');
	}

}

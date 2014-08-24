<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveTracklistAndVideosFromVinyls extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vinyls', function(Blueprint $table)
		{
			$table->dropColumn('tracklist');
			$table->dropColumn('videos');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vinyls', function(Blueprint $table)
		{
			
		});
	}

}

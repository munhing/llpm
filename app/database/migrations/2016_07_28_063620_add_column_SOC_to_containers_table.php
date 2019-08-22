<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColumnSOCToContainersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('containers', function(Blueprint $table)
		{
			$table->boolean('is_soc')->after('status');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('containers', function(Blueprint $table)
		{
			$table->dropColumn('is_soc');
		});
	}

}

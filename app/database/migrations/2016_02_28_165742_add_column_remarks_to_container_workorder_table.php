<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColumnRemarksToContainerWorkorderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('container_workorder', function(Blueprint $table)
		{
			$table->string('remark')->after('lifter');	
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('container_workorder', function(Blueprint $table)
		{
			$table->dropColumn('remark');
		});
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColumnOperatorToContainerWorkorderConfirmationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('container_workorder_confirmation', function(Blueprint $table)
		{
			$table->integer('operator_id')->after('confirmed_by');	
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('container_workorder_confirmation', function(Blueprint $table)
		{
			$table->dropColumn('operator_id');
		});
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColumnBondRentToWorkordersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('workorders', function(Blueprint $table)
		{
			$table->decimal('bond_rent', 10, 2)->after('finalized');	
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('workorders', function(Blueprint $table)
		{
            $table->dropColumn('bond_rent');
		});
	}

}

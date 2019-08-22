<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColumnDaysBondImportAndDaysBondExportToContainersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('containers', function(Blueprint $table)
		{
			$table->integer('days_bond_import')->after('m_content');	
			$table->integer('days_bond_export')->after('days_bond_import');	
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
			$table->dropColumn('days_bond_import');
			$table->dropColumn('days_bond_export');
		});
	}

}

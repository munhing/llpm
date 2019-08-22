<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContainersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('containers', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('container_no');
			$table->integer('size');
			$table->string('content');
			$table->integer('location');
			$table->integer('status');
			$table->integer('current_movement')->unsigned();
			$table->string('to_confirm_by');
			$table->integer('check_point');
			$table->integer('dl_check');
			$table->integer('pre_stuffing');
			$table->string('m_content');
			$table->integer('days_empty');
			$table->integer('days_laden');
			$table->integer('days_total');
			$table->integer('import_vessel_schedule_id')->unsigned();
			$table->integer('export_vessel_schedule_id')->unsigned();
			$table->integer('receiving_id')->unsigned();
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
		Schema::drop('containers');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVesselScheduleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vessel_schedule', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('registered_vessel_id')->unique();
			$table->integer('vessel_id');
			$table->integer('portuser_id');
			$table->string('voyage_no_arrival');
			$table->string('voyage_no_departure');
			$table->timestamp('eta');
			$table->timestamp('etd');
			$table->decimal('mt_arrival', 10, 5);
			$table->decimal('mt_departure', 10, 5);
			$table->decimal('m3_arrival', 10, 5);
			$table->decimal('m3_departure', 10, 5);
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
		Schema::drop('vessel_schedule');
	}

}

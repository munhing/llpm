<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkordersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('workorders', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('movement');
			$table->timestamp('date');
			$table->integer('carrier_id');
			$table->integer('handler_id');
			$table->integer('agent_id');
			$table->integer('vessel_schedule_id');
			$table->integer('container_location');
			$table->integer('container_status');
			$table->string('who_is_involved');		
			$table->integer('finalized');
			$table->decimal('storage_charges', 10, 2);
			$table->decimal('handling_charges', 10, 2);							
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
		Schema::drop('workorders');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContainerWorkorderConfirmationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('container_workorder_confirmation', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('container_id')->unsigned();
			$table->string('container_no');
			$table->integer('workorder_id')->unsigned();
			$table->integer('container_workorder_id')->unsigned();
			$table->integer('confirmed_by');		
			$table->string('role');		
			$table->timestamp('confirmed_at');			
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
		Schema::drop('container_workorder_confirmation');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContainerWorkorderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('container_workorder', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('container_id')->unsigned()->index();
			$table->foreign('container_id')->references('id')->on('containers')->onDelete('cascade');
			$table->integer('workorder_id')->unsigned()->index();
			$table->foreign('workorder_id')->references('id')->on('workorders')->onDelete('cascade');
			$table->string('movement');
			$table->string('content');
			$table->string('vehicle');
			$table->string('lifter');
			$table->boolean('confirmed');
			$table->integer('confirmed_by');			
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
		Schema::drop('container_workorder');
	}

}

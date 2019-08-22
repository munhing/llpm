<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContainerConfirmationProcessTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('container_confirmation_process', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('movement');
			$table->integer('total_check_points');
			$table->string('cp1');
			$table->string('cp2');
			$table->string('cp3');
			$table->string('cp4');
			$table->string('cp5');
			$table->string('cp6');
			$table->string('cp7');
			$table->string('cp8');
			$table->string('cp9');
			$table->string('cp10');
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
		Schema::drop('container_confirmation_process');
	}

}

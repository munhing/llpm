<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCargoContainerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cargo_container', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('cargo_id')->unsigned()->index();
			$table->foreign('cargo_id')->references('id')->on('cargoes')->onDelete('cascade');
			$table->integer('container_id')->unsigned()->index();
			$table->foreign('container_id')->references('id')->on('containers')->onDelete('cascade');
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
		Schema::drop('cargo_container');
	}

}

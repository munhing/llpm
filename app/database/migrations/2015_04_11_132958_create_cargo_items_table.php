<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCargoItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cargo_items', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('cargo_id')->unsigned();
			$table->string('custom_tariff_code');
			$table->string('description');
			$table->decimal('quantity', 10, 5);	
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
		Schema::drop('cargo_items');
	}

}

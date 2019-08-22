<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomTariffTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('custom_tariff', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code')->unique();
			$table->string('description')->nullable();
			$table->string('uoq');
			$table->boolean('group');
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
		Schema::drop('custom_tariff');
	}

}

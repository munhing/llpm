<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCargoesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cargoes', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('bl_no');
			$table->integer('consignor_id');
			$table->integer('consignee_id');			
			$table->decimal('mt', 10, 5);
			$table->decimal('m3', 10, 5);
			$table->integer('status');
			$table->text('description');
			$table->text('markings');
			$table->boolean('containerized');
			$table->string('custom_reg_no');
			$table->string('country_code');
			$table->string('port_code');
			$table->string('custom_form_no');
			$table->integer('dl_no')->unsigned();
			$table->integer('import_vessel_schedule_id')->unsigned();
			$table->integer('export_vessel_schedule_id')->unsigned();
			$table->integer('receiving_id')->unsigned();
			$table->integer('received_by');
			$table->timestamp('received_date');	
			$table->integer('issued_by');
			$table->timestamp('issued_date');	
			$table->integer('released_by');
			$table->timestamp('released_date');								
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
		Schema::drop('cargoes');
	}

}

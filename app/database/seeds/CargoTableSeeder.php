<?php

use Carbon\Carbon;

class CargoTableSeeder extends Seeder
{

	public function run()
	{
		$faker = Faker\Factory::create();

		// fake data
		// $import_vessel_schedule_id = 284;
		// $receiving_id = 0;

		// for ($i=0;$i<100;$i++) {

		// 	$eta = $faker->dateTimeThisYear()->format('Y-m-d');

		// 	$etd = Carbon::createFromFormat('Y-m-d', $eta)->addDays($faker->randomDigit);

		// 	Cargo::create([
		// 		'bl_no' => $faker->bothify('SLLBU##########'),
		// 		'consignor_id' => PortUser::orderBy(DB::raw('RAND()'))->first()->id,
		// 		'consignee_id' => PortUser::orderBy(DB::raw('RAND()'))->first()->id,
		// 		'mt' => $faker->randomFloat(2, 1, 2500),
		// 		'm3' => $faker->randomFloat(2, 1, 2500),
		// 		'status' => 1,
		// 		'description' => $faker->paragraph(),
		// 		'markings' => $faker->paragraph(),
		// 		'import_vessel_schedule_id' => $import_vessel_schedule_id,
		// 		'receiving_id' => $receiving_id = 0
		// 	]);
		// }
	
		// real data for Import Cargo July 2015
		$results = DB::select('select * from cargo where crgid > ? limit 20000', array(139522));

		// dd(count($results));

		foreach($results as $row) {

			var_dump('Proccessing '. $row->crgid);

			$cargo = Cargo::create(array(
				'id'	=> $row->crgid,
				'bl_no'	=> $row->crgblno,
				'consignee_id'	=> $row->crgcsgnid,
				'consignor_id'	=> $row->crgcsgnid,
				'mt'	=> $row->crgmt,
				'm3'	=> $row->crgm3,
				'status' => 1,
				'description'	=> $row->crgdesc,
				'markings'	=> $row->crgmarks,
				'port_code'	=> $row->crgorigin,
				'custom_form_no'	=> $row->crgkno ? 'K' . $row->crgkno : '',
				'dl_no'	=> $row->crgdl,
				'import_vessel_schedule_id'	=> $row->crgvsid
			));

			if($row->crglanded != '0000-00-00') {
				$cargo->received_by = 1;
				$cargo->received_date = $row->crglanded;
				$cargo->status = 2;
				$cargo->save();
			}

			if($row->crgissued != '0000-00-00') {
				$cargo->issued_by = 1;
				$cargo->issued_date = $row->crgissued;
				$cargo->status = 3;
				$cargo->save();
			}

			if($row->crgdelivered != '0000-00-00') {
				$cargo->released_by = 1;
				$cargo->released_date = $row->crgdelivered;
				$cargo->status = 4;
				$cargo->save();
			}

			if($row->crgdl != 0) {
				ImportDL::create([
					'id' => $row->crgdl,
					'cargo_id' => $row->crgid
				]);
			}
		}

	}
}
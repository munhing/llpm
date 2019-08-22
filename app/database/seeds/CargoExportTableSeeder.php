<?php

use Carbon\Carbon;

class CargoExportTableSeeder extends Seeder
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
	
		// real data for Import Cargo
		// $results = DB::select('select * from cargoexport where crgexid > ? limit 20000', array(30162));
		$results = DB::select('select * from cargoexport where crgexid > ? limit 20000', array(35701));

		// dd(count($results));

		foreach($results as $row) {

			var_dump('Proccessing '. $row->crgexid);

			$shipper = DB::select("select * from shipper where shid = ?", array($row->crgexshid));

			$portuser = PortUser::where('name', $shipper[0]->shname)->first();

			$cargo = Cargo::create(array(
				'id'	=> $row->crgexid,
				'bl_no'	=> $row->crgexblno,
				'consignee_id'	=> $portuser->id,
				'consignor_id'	=> $portuser->id,
				'mt'	=> $row->crgexmt,
				'm3'	=> $row->crgexm3,
				'description'	=> $row->crgexdesc,
				'markings'	=> $row->crgexmarks,
				'port_code'	=> $row->crgexdestination,
				'custom_form_no'	=> $row->crgexkno ? 'K' . $row->crgexkno : '',
				'dl_no'	=> $row->crgexdl,
				'export_vessel_schedule_id'	=> $row->crgexvsid
			));

			if($row->crgexlanded != '0000-00-00') {
				$cargo->received_by = 1;
				$cargo->received_date = $row->crgexlanded;
				$cargo->status = 2;
				$cargo->save();
			}

			if($row->crgexissued != '0000-00-00') {
				$cargo->issued_by = 1;
				$cargo->issued_date = $row->crgexissued;
				$cargo->status = 3;
				$cargo->save();
			}

			if($row->crgexdelivered != '0000-00-00') {
				$cargo->released_by = 1;
				$cargo->released_date = $row->crgexdelivered;
				$cargo->status = 4;
				$cargo->save();
			}
			if($row->crgexdl != 0) {
				ExportDL::create([
					'id' => $row->crgexdl,
					'cargo_id' => $row->crgexid
				]);
			}
		}

	}
}
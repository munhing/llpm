<?php

class PortUserTableSeeder extends Seeder
{

	public function run()
	{
		// $faker = Faker\Factory::create();

		// for ($i=0;$i<100;$i++) {
		// 	PortUser::create([
		// 		'name' => $faker->company
		// 	]);	
		// }

		// Option 1
		// $json = File::get(storage_path() . "/jsondata/portuser.json");
		// $portusers = json_decode($json);

		// //dd($vessels);
		// foreach ($portusers as $portuser) {

		// 	//dd($vessel->name);
		// 	PortUser::create(array(
		// 		'name' => $portuser->name
		// 	));
		// }	

		// Option 2
		$results = DB::select('select * from consignee', array());
		foreach($results as $row) {
			PortUser::create(array(
				'id'	=> $row->csgnid,
				'name' => $row->csgnname
			));
		}

		$results = DB::select('select * from shipper', array());
		foreach($results as $row) {

			if(PortUser::where('name', $row->shname)->count() == 0) {

				PortUser::create(array(
					'name' => $row->shname
				));
			}
		}

		$results = DB::select('select * from agent', array());
		foreach($results as $row) {

			if(PortUser::where('name', $row->aname)->count() == 0) {

				PortUser::create(array(
					'name' => $row->aname
				));
			}
		}

		$results = DB::select('select * from handler', array());
		foreach($results as $row) {

			if(PortUser::where('name', $row->hname)->count() == 0) {

				PortUser::create(array(
					'name' => $row->hname
				));
			}
		}

	}
}
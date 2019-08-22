<?php

class VesselTableSeeder extends Seeder
{

	public function run()
	{
		// $faker = Faker\Factory::create();

		// for ($i=0;$i<100;$i++) {
		// 	Vessel::create([
		// 		'name' => $faker->company
		// 	]);	
		// }

		// Option 1
		// $json = File::get(storage_path() . "/jsondata/vessel.json");
		// $vessels = json_decode($json);

		// //dd($vessels);
		// foreach ($vessels as $vessel) {

		// 	//dd($vessel->name);
		// 	Vessel::create(array(
		// 		'name' => $vessel->name
		// 	));
		// }

		// Option 2
		$results = DB::select('select * from vessel', array());
		foreach($results as $row) {
			Vessel::create(array(
				'id'	=> $row->vid,
				'name' => $row->vname
			));
		}

	}
}
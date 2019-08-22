<?php

use Carbon\Carbon;

class VesselScheduleTableSeeder extends Seeder
{

	public function run()
	{
		$faker = Faker\Factory::create();

		// Generate Test Data
		// for ($i=0;$i<500;$i++) {

		// 	$eta = $faker->dateTimeThisYear()->format('Y-m-d');

		// 	$etd = Carbon::createFromFormat('Y-m-d', $eta)->addDays($faker->randomDigit);

		// 	VesselSchedule::create([
		// 		'vessel_id' => Vessel::orderBy(DB::raw('RAND()'))->first()->id,
		// 		'portuser_id' => PortUser::orderBy(DB::raw('RAND()'))->first()->id,
		// 		'voyage_no_arrival' => $faker->bothify('##/###'),
		// 		'voyage_no_departure' => $faker->bothify('##/###'),
		// 		'eta' => $eta,
		// 		'etd' => $etd,
		// 		'mt_arrival' => $faker->randomFloat(2, 1, 2500),
		// 		'mt_departure' => $faker->randomFloat(2, 1, 2500),
		// 		'm3_arrival' => $faker->randomFloat(2, 1, 2500),
		// 		'm3_departure' => $faker->randomFloat(2, 1, 2500)
		// 	]);
		// }
		
		// Import real data
		$results = DB::select('select * from vschedule', array());

		// dd('Schedule');

		$errors = [];

		// dd(count($results));		
		foreach($results as $row) {

			// get the correct agent_id
			$agent = DB::select("select * from agent where aid = ?", array($row->vsaid));
			// dd($agent[0]->aid);
			if(count($agent) != 0) {

				$portuser = PortUser::where('name', $agent[0]->aname)->first();

				// dd($portuser_id->id);
				// if there's error, it will not stop but it will be added to the $error variable
				try{
					VesselSchedule::create(array(
						'id'			=> $row->vsid,
						'registered_vessel_id' => $row->vsid,
						'vessel_id' 	=> $row->vsvid,
						'portuser_id' 	=> $portuser->id,
						'voyage_no_arrival' 	=> $row->vsvoy,
						'voyage_no_departure' 	=> $row->vsvoyex,
						'eta' 					=> $row->vseta,
						'etd' 					=> $row->vsetd,
						'mt_arrival' 			=> $row->vsmt,
						'mt_departure' 			=> $row->vsmtex,
						'm3_arrival' 			=> $row->vsm3,
						'm3_departure' 			=> $row->vsm3ex
					));

				} catch (Exception $e){
					var_dump($row->vsid);
				}
			}
		}

		// var_dump($errors);
	}
}
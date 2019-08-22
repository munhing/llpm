<?php

use Carbon\Carbon;

class WorkOrderTableSeeder extends Seeder
{

	public function run()
	{
		$faker = Faker\Factory::create();

		$errors = [];

		// real data 2015 July onwards
		// $results = DB::select('select * from workorder where woid > ?', array(104623));
		
		// 2015 onwards
		$results = DB::select('select * from workorder where woid > ? limit 20000', array(98299));

		// dd(count($results));

		foreach($results as $row) {

			if($row->wocarrier != 0) {
				$wocarrier = DB::select("select * from handler where hid = ?", array($row->wocarrier));
				if(count($wocarrier) != 0) {
					$carrier = PortUser::where('name', $wocarrier[0]->hname)->first();
					$carrier_id = $carrier->id;
				} else {
					$carrier_id = 1;
				}
			}

			$wohandler = DB::select("select * from handler where hid = ?", array($row->wohid));
			if(count($wohandler) != 0) {
				$handler = PortUser::where('name', $wohandler[0]->hname)->first();
				$handler_id = $handler->id;
			} else {
				$handler_id = 1;
			}
			// dd($agent[0]->aid);
			$proceed = true;

			if($row->wom == 'HI' || $row->wom == 'HE') {
				$schedule = VesselSchedule::find($row->wovsid);
				if(count($schedule) == 0){
					$proceed = false;
				}
			}

			$movement = $row->wom;

			if($row->wom == 'T1') {
				$movement = 'TF-3-1';
			}

			if($row->wom == 'T2') {
				$movement = 'TF-1-3';
			}

			// if($row->wom == 'EM') {
			// 	$results2 = DB::select('select * from containermovement where ctnmwonoin = ? limit 1', array($row->wono));
			// 	if($results2) {
			// 		foreach($results2 as $row2) {
			// 			if($row2->ctnmstatusin == 'L') {
			// 				$movement = 'US';
			// 			} else {
			// 				$movement = 'ST';
			// 			}
						
			// 		}
			// 	} else {

			// 		$movement = 'US';
			// 	}				
			// }

			if($row->wom == 'RI') {

				$results2 = DB::select('select * from containermovement where ctnmwonoin = ? limit 1', array($row->wono));
				if($results2) {
					foreach($results2 as $row2) {
						if($row2->ctnmstatusin == 'L') {
							$movement = 'RI-1';
						} else {
							$movement = 'RI-3';
						}
						
					}
				} else {

					$movement = 'RI-3';
				}

			}

			if($row->wom == 'RO') {

				$results2 = DB::select('select * from containermovement where ctnmwonoout = ? limit 1', array($row->wono));
				if($results2) {
					foreach($results2 as $row2) {
						if($row2->ctnmstatusout == 'L') {
							$movement = 'RO-1';
						} else {
							$movement = 'RO-3';
						}
						
					}
				} else {

					$movement = 'RO-3';
				}

			}

			if($proceed){
				try{

					// var_dump('Registering '. $row->wono);

					WorkOrder::create(array(
						'id'		=> $row->wono,
						'movement'	=> $movement,
						'date'		=> $row->wodate,
						'carrier_id'	=> $carrier_id,
						'handler_id'	=> $handler_id,
						'vessel_schedule_id'	=> $row->wovsid,
						'storage_charges'		=> $row->emptycharges,
						'handling_charges'		=> $row->hdlcharges
					));
				} catch(Exception $e) {
					var_dump($row->wono);
				}
			}
		}

		// var_dump($errors);

	}
}
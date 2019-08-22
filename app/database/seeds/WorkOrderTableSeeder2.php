<?php

use Carbon\Carbon;

class WorkOrderTableSeeder2 extends Seeder
{

	public function run()
	{


		// restore containers from workorder # 120680 - 121489
		
		$workorders = WorkOrder::where('id', '>', '119862')
						->where('movement', 'EM')
						->get();

		dd(count($workorders));

		foreach($workorders as $wo) {

			$containers = $wo->containers;
			if(count($containers) > 0){
				$pattern = $this->getPattern($containers, $wo);

				var_dump($pattern);
				if($pattern == 'HIEM') {
					$wo->movement = 'US';
					$wo->save();
					var_dump($wo->id . ' changed to US!');
				}

				if($pattern == 'HITF-1-3EM') {
					$wo->movement = 'US';
					$wo->save();
					var_dump($wo->id . ' changed to US!');
				}

				if($pattern == 'RI-3TF-3-1EM') {
					$wo->movement = 'ST';
					$wo->save();
					var_dump($wo->id . ' changed to ST!');
				}
				if($pattern == 'HIUSTF-1-3TF-3-1EM') {
					$wo->movement = 'ST';
					$wo->save();
					var_dump($wo->id . ' changed to ST!');
				}	
				if($pattern == 'RI-3TF-3-1HEEM') {
					$wo->movement = 'ST';
					$wo->save();
					var_dump($wo->id . ' changed to ST!');
				}		
				if($pattern == 'HIUSTF-1-3TF-3-1TF-1-3TF-3-1EM') {
					$wo->movement = 'ST';
					$wo->save();
					var_dump($wo->id . ' changed to ST!');
				}	
				if($pattern == 'RI-3TF-3-1TF-1-3TF-3-1EM') {
					$wo->movement = 'ST';
					$wo->save();
					var_dump($wo->id . ' changed to ST!');
				}	
				if($pattern == 'HIUSTF-1-3TF-1-3TF-3-1EM') {
					$wo->movement = 'ST';
					$wo->save();
					var_dump($wo->id . ' changed to ST!');
				}
				if($pattern == 'RI-3TF-1-3TF-3-1EM') {
					$wo->movement = 'ST';
					$wo->save();
					var_dump($wo->id . ' changed to ST!');
				}
				if($pattern == 'HIUSEM') {
					$wo->movement = 'ST';
					$wo->save();
					var_dump($wo->id . ' changed to ST!');
				}																							
			}
		}
	}

	public function getPattern($containers, $workorder)
	{
		$ctn = $containers->first();

		// get workorders
		
		$workorders = $ctn->workorders->sortBy('id');

		$pattern = '';
		foreach($workorders as $wo) {
			$pattern .= $wo->movement;

			if($wo->id == $workorder->id) {
				return $pattern;
			}
		}

		return $pattern;
	}
}
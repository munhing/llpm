<?php

use Carbon\Carbon;

class ConvertEMToActivity extends Seeder
{

	public function run()
	{

		$errors = [];

		$workorders = WorkOrder::where('movement', 'EM')
			->orderBy('id', 'desc')
			->take(200)
			->get();

		// dd($workorders->toArray());
		$count =0;

		foreach($workorders as $wo) {
			$count++;
			// $container = $wo->containers->first()->get();
			
			$results = $wo->containers;

			if(count($results) > 0) {

				$ctn_id = $results->first()->id;

				$container = Container::find($ctn_id);

				$i = 0;
				$pattern = '';
				foreach($container->workorders as $workorder) {
					$i++;
					$pattern .= $workorder->movement;

					if($workorder->id == $wo->id) {
						var_dump($count . " - " . $i . " - " . $workorder->id . " : " . $pattern);

						if($pattern == 'HIEM') {
							// convert WO movement to US
							$this->convertToUS($wo);
						}

						$pos = strpos($pattern, 'TF-3-1EM');

						// var_dump($pos);

						if($pos != false) {
							// convert WO movement to US
							$this->convertToST($wo);
						}						
					}
				}
			} else {
				var_dump($count . " - " . $wo->id . " : No containers!");				
			}


		}
	}

	public function convertToUS($workorder)
	{
		//change workorder movement to US
		$workorder->movement = 'US';
		$workorder->save();

		//change pivot table movement to US
		$containers = $workorder->containers;

		if(count($containers) > 0) {
			foreach($containers as $ctn) {
				var_dump('Saving... : ' . $ctn->id . " : " . $ctn->container_no);
				$ctn->pivot->movement = 'US';
				$ctn->pivot->save();
			}
		}

	}

	public function convertToST($workorder)
	{
		var_dump('Convert to ST');
		//change workorder movement to US
		$workorder->movement = 'ST';
		$workorder->save();

		//change pivot table movement to US
		$containers = $workorder->containers;

		if(count($containers) > 0) {
			foreach($containers as $ctn) {
				var_dump('Saving... : ' . $ctn->id . " : " . $ctn->container_no);
				$ctn->pivot->movement = 'ST';
				$ctn->pivot->save();
			}
		}		
	}

    function getInvolvement($movement)
    {
        $who_is_involved = [];

        $ccp = ContainerConfirmationProcess::where('movement', $movement)->first();

        for($i=1;$i<=4;$i++) {

            if(!$ccp->{'cp'.$i}){continue;}

            $who_is_involved[] = $ccp->{'cp'.$i};
        }

        return json_encode($who_is_involved);  
    }	
}
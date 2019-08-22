<?php

use Carbon\Carbon;

class WorkOrderTransformMovement2TableSeeder extends Seeder
{

	public function run()
	{
		$faker = Faker\Factory::create();

		$errors = [];

		// real data 2014 onwards
		// $workorders = WorkOrder::take(10000)->get();
		// $workorders = WorkOrder::skip(10000)->take(10000)->get();
		// $workorders = WorkOrder::skip(20000)->take(10000)->get();
		$workorders = WorkOrder::skip(30000)->take(10000)->get();
		// DB::table('users')->skip(10)->take(5)->get();
		// $workorders = WorkOrder::take(100)->get();

		foreach($workorders as $wo) {
			var_dump($wo->id);
			if(count($wo->containers) != 0) {
				// get who_is_involved
				
				$who_is_involved = $this->getInvolvement($wo->movement);


				// $wo->movement = $movement;
				$wo->who_is_involved = $who_is_involved;
				$wo->save();
			}
		}



		// var_dump($errors);

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
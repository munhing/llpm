<?php

use Carbon\Carbon;

class UpdateSchedule extends Seeder
{

	public function run()
	{

		$eta = Carbon::now();
		$etd = Carbon::now()->addWeeks(2);

		DB::table('vessel_schedule')
            ->where('id', 284)
            ->update([
            	'eta' => $eta, 
            	'etd' => $etd
            ]);
					
	}
}
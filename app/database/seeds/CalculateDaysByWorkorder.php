<?php

use Carbon\Carbon;

class CalculateDaysByWorkorder extends Seeder
{
	public function run()
	{
		$calculateContainerDays = App::make('LLPM\Containers\CalculateContainerDays2');
		$containerRepository = App::make('LLPM\Repositories\ContainerRepository');

		$workorder = WorkOrder::find(121528);

        $containers = $workorder->containers;

        // dd($containers->count());

        // 2. Loop each container
        foreach($containers as $container) {

            // 3. Calculate container's days empty and laden
            // this need to create a command of it's own because there will be other class needing this
            // {"L":11,"E":0,"total":11}
            Log::info("Calculating container#: $container->container_no");

            $days = $calculateContainerDays->fire($container);

            var_dump($container->container_no);
            var_dump($days);

            Log::info(" => Done, updating to database...");
            
            // 4. Update DB
            $containerRepository->updateDays($container->id, $days);
            Log::info(" => Updated! \n");
        }
	}


}
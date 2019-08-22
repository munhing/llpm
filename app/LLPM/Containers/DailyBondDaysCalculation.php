<?php

namespace LLPM\Containers;

use Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use LLPM\Containers\CalculateBondDays;
use LLPM\Repositories\ContainerRepository;

class DailyBondDaysCalculation
{

    protected $containerRepository;
    protected $calculateBondDays;

	function __construct(
        ContainerRepository $containerRepository,
        CalculateBondDays $calculateBondDays
    )
	{
        $this->containerRepository = $containerRepository;
        $this->calculateBondDays = $calculateBondDays;
	}

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function fire()
    {
        // 1. Obtain all active containers in the port, those with status 3
        $containers = $this->containerRepository->getAllActive();
        
        // $containers = $this->containerRepository->getSpecificContainer(181216);

        // dd($containers->count());

        // 2. Loop each container
        foreach($containers as $container) {

            // 3. Calculate container's bond days for import and export
            // this need to create a command of it's own because there will be other class needing this
            // {"import":11,"export":0}
            Log::info("Calculating container#: $container->container_no");
            // echo 'Calculating container #:' . $container->container_no;
            // die();
            $days = $this->calculateBondDays->fire($container);
            
            // 4. Update DB
            $this->containerRepository->updateBondDays($container->id, $days);
            Log::info(" => Updated! \n");
            echo "Done!";
        }
        

   	
	}    
}
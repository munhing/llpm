<?php

namespace LLPM\Containers;

use Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use LLPM\Containers\CalculateBondDays;
use LLPM\Repositories\ContainerRepository;

class BondDaysCalculationByWorkOrder
{

    protected $containerRepository;
    protected $calculateContainerDays;

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
    public function fire($workorder)
    {
        // 1. List all containers for the workorder
        
        $containers = $workorder->containers;

        // 2. Loop each container
        foreach($containers as $container) {

            // 3. Calculate bond days for each container
            Log::info("Calculating Bond Days for Container #: $container->container_no");

            $days = $this->calculateBondDays->fire($container);

            // 4. Update DB
            $this->containerRepository->updateBondDays($container->id, $days);
            Log::info(" => Updated! \n");
        }
        

   	
	}    
}
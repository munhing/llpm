<?php 

namespace LLPM\WorkOrders;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\WorkOrderRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\WorkOrders\CalculateChargesByWorkOrder;

class CancelContainerCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $workOrderRepository;
	protected $containerRepository;
    protected $calculateChargesByWorkOrder;

	function __construct(
        WorkOrderRepository $workOrderRepository, 
        ContainerRepository $containerRepository, 
        calculateChargesByWorkOrder $calculateChargesByWorkOrder)
	{
		$this->workOrderRepository = $workOrderRepository;
		$this->containerRepository = $containerRepository;
        $this->calculateChargesByWorkOrder = $calculateChargesByWorkOrder;
	}

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {
    	
		//dd($command);

        //detach container from workorder
        $workorder = $this->workOrderRepository->cancelContainer($command->workorder_id, $command->container_id);

        //update containers.current_movement = 0
        if($workorder) {
            $container = $this->updateContainer($command->container_id);
        }

		// Calculate again the handling and storage charges
        $workorder = $this->workOrderRepository->getById($command->workorder_id); 
        $this->calculateChargesByWorkOrder->fire($workorder);

		return $container;    	
    }

    function updateContainer($container_id)
    {
        $container = $this->containerRepository->getById($container_id);
        $container->current_movement = 0;
        $container->to_confirm_by = '';
        $container->check_point = 0;
        $container->pre_stuffing = 0;
        $container->save();

        return $container;
    }

}
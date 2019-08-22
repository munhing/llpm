<?php 

namespace LLPM\WorkOrders;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\WorkOrderRepository;
use WorkOrder;
use Activity;

class FinalizeWorkOrderCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $workOrderRepository;

	function __construct(
        WorkOrderRepository $workOrderRepository
    )
	{
		$this->workOrderRepository = $workOrderRepository;
	}

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {
        // dd($command);

        // check for unconfirmed containers
        $workorder = $this->workOrderRepository->getDetailsById($command->workorder_id);

        if(! $this->isAllContainersConfirmed($workorder)) {
            return false;
        }

        // Finalized workorder
        $workOrder = WorkOrder::finalize(
            $command->workorder_id
        );

        $this->workOrderRepository->save($workOrder);

        Activity::log('Workorder ' . $workOrder->id . ' was finalized');

        return $workOrder;
    }

    public function isAllContainersConfirmed($workorder)
    {
        foreach($workorder->containers as $container) {
            if($container->pivot->confirmed == 0) {
                return false;
            }
        }

        return true;        
    }

}
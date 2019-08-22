<?php 

namespace LLPM\WorkOrders;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\WorkOrderRepository;
use WorkOrder;
use Activity;

class UpdateWorkOrderWithAgentCommandHandler implements CommandHandler {

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

        $workorder->agent_id = $command->agent_id;
        $workorder->save();

        Activity::log('Agent id, '. $command->agent_id .' selected for Workorder ' . $workorder->id);

        return $workorder;
    }
}
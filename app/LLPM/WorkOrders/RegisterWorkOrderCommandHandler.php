<?php 

namespace LLPM\WorkOrders;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\WorkOrderRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\ContainerConfirmationProcessRepository;
use WorkOrder;
use App;
use Activity;
use Auth;
use LLPM\WorkOrders\AttachedContainersToWorkOrderCommandHandler;
use LLPM\WorkOrders\CalculateChargesByWorkOrder;

class RegisterWorkOrderCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $workOrderRepository;
    protected $containerRepository;
	protected $containerConfirmationProcessRepository;
    protected $attachedContainersToWorkOrder;
    protected $calculateChargesByWorkOrder;

	function __construct(
        WorkOrderRepository $workOrderRepository, 
        ContainerRepository $containerRepository, 
        ContainerConfirmationProcessRepository $containerConfirmationProcessRepository,
        AttachedContainersToWorkOrderCommandHandler $attachedContainersToWorkOrder,
        CalculateChargesByWorkOrder $calculateChargesByWorkOrder
    )
	{
		$this->workOrderRepository = $workOrderRepository;
        $this->containerRepository = $containerRepository;
		$this->containerConfirmationProcessRepository = $containerConfirmationProcessRepository;
        $this->attachedContainersToWorkOrder = $attachedContainersToWorkOrder;
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
        // dd($command);
        $workOrder = $this->registerWorkOrder($command);

        $command->workorder_id = $workOrder->id;

        $this->attachedContainersToWorkOrder->handle($command);
        
        // calculate storage and handling charges and save it to workorder
        $this->calculateChargesByWorkOrder->fire($workOrder);

		return $workOrder;    	
    }

    function registerWorkOrder($command)
    {
        $date = \Carbon\Carbon::now();
        $carrier_id = $command->carrier_id;
        $vessel_schedule_id = 0;
        $movement = explode('-', $command->type);
        
        if($command->type == 'HI' || $command->type == 'HE') {
            $carrier_id = 0;
            $vessel_schedule_id = $command->carrier_id;
        }
        
        // generate workorder no
        $container_location = $this->getLocation($command);
        $container_status = $this->getStatus($command);
        $who_is_involved = $this->getInvolvement($command->type);

        // dd($container_location);

        $workOrder = WorkOrder::register(
            $command->type, 
            $date,
            $carrier_id, 
            $command->handler_id,
            $vessel_schedule_id,
            $container_location,
            $container_status,
            $who_is_involved,
            Auth::user()->id
        );

        //dd($workOrder->toArray());
        
        $this->workOrderRepository->save($workOrder);

        Activity::log('Some activity that you wish to log');

        return $workOrder;    
    }

    function getInvolvement($type)
    {
        $who_is_involved = [];

        $ccp = $this->containerConfirmationProcessRepository->getProcess($type);

        for($i=1;$i<=4;$i++) {

            if(!$ccp->{'cp'.$i}){continue;}

            $who_is_involved[] = $ccp->{'cp'.$i};
        }

        return json_encode($who_is_involved);  
    }

    function triggerPusher($to_confirm_by, $containers)
    {
        $pusher = App::make('Pusher');
        $pusher->trigger('LLPM', $to_confirm_by, json_encode($containers));        
    }

    function getLocation($command)
    {
        $movement = explode('-', $command->type);
    	$location = 0;

        // dd($movement);

    	switch($movement[0]) {

    		case 'HI':
                $location = 1;
                break;              
            case 'US':
                $location = (int) $movement[1];
                // dd($location);
                break;
            case 'ST':                   
    			$location = (int) $movement[1];
    			break;
    		case 'TF':
    			$location = (int) $movement[2];
    			break;    			
    		case 'HE':
    		case 'RO':
    			$location = 0;
    			break;  
    		case 'RI':
    			$location = (int) $movement[1];
    			break;	
            case 'VGM':
                $location = 1;
                break;                	
    	}

    	return $location;
    }

    function getStatus($command)
    {
    	$movement = explode('-', $command->type);
        $status = 0;

    	switch($movement[0]) {

    		case 'HI':
    		case 'RI':
    		case 'TF':
            case 'US':                      
            case 'ST':                      
    		case 'VGM':    		    		
    			$status = 3;
    			break;
    		case 'HE':
    		case 'RO':    		
    			$status = 4;
    			break;    			
    	}

    	return $status;
    }

}
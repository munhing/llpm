<?php 
namespace LLPM\Containers;

use Carbon\Carbon;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\WorkOrderRepository;

class ContainerTrackingStatus
{
    protected $containerRepository;
    protected $workOrderRepository;
    protected $containerNotFound = [];

	function __construct(
        ContainerRepository $containerRepository,
        WorkOrderRepository $workOrderRepository
    )
	{
        $this->containerRepository = $containerRepository;
        $this->workOrderRepository = $workOrderRepository;
	}

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function fire($search_input)
    {
        $containers = $this->getValidContainers($search_input);
        // dd($containers);

        $info['containers'] = $this->getContainersInfo($containers);

        // dd($this->containerNotFound);
        $info['containers_not_found'] = $this->containerNotFound;

        return $info;
    }

    public function getContainersInfo($containers)
    {
        $info = [];

        foreach($containers as $ctn) {
            $info[] = $this->getIndividualContainerInfo($ctn);
        }

        return $info;
    }

    public function getIndividualContainerInfo($container)
    {
        $info['id'] = $container->id;
        $info['container_no'] = $container->container_no;
        $info['size'] = $container->size;
        $info['status'] = $container->status;
        $info['content'] = $container->content;
        $info['location'] = $container->location;
        $info['current_movement'] = $container->current_movement;
        $info['import_vessel_schedule_id'] = $container->import_vessel_schedule_id;
        $info['export_vessel_schedule_id'] = $container->export_vessel_schedule_id;

        if($info['current_movement'] != 0) {
            $info['workorder_movement'] = $this->workOrderRepository->getById($info['current_movement'])->movement;
        }

        $info['status_interpreter'] = '';

        if($info['status'] == 1) {
            $info['status_interpreter'] = 'Currently On Board vessel ' . $container->vessel_schedule_import . '.'; 
        }

        if($info['status'] == 2) {
            $info['status_interpreter'] = 'Currently with agent and registered in receiving on '. $container->receiving->date->format('d/m/Y') . '.'; 
        }

        if($info['status'] == 3) {
            $info['status_interpreter'] = 'Currently in Container Yard ' . $info['location'] . '.'; 
        }

        if($info['status'] == 4) {
            $info['status_interpreter'] = 'This container is no longer in the yard.'; 
        }

        if($info['current_movement'] != 0) {
            $info['status_interpreter'] .= ' Pending confirmation for Work Order #: ' . $info['current_movement'] . '.';

            if(isset($info['workorder_movement'])) {
                if($info['workorder_movement'] == 'VGM') {
                    $info['status_interpreter'] = 'This container is undergoing verification for Gross Mass.  Pending confirmation for Work Order #: ' . $info['current_movement'] . '.';
                }
            }
        } else {
            if($info['status'] == 1 || $info['status'] == 2) {
                $info['status_interpreter'] .= ' No Work Order being issued yet.';  
            }

            if($info['status'] == 3) {
                $info['status_interpreter'] .= ' No pending Work Order.';  
            }            
        }

        return $info;
	}

    public function getValidContainers($input)
    {
        $valid_containers = [];
        $arrays = array_unique(explode(",", $input));

        foreach($arrays as $a) {
            $container = $this->containerRepository->getLatestByContainerNo($a)->first();

            if($container) {
                $valid_containers[] = $container;
            } else {
                $this->containerNotFound[] = $a;
            }
           
        }

        return $valid_containers;
    }

}
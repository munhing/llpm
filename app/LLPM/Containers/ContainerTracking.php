<?php 
namespace LLPM\Containers;

use Carbon\Carbon;
use LLPM\Repositories\ContainerRepository;

class ContainerTracking
{
    protected $containerRepository;
    protected $containerNotFound = [];

	function __construct(
        ContainerRepository $containerRepository
    )
	{
        $this->containerRepository = $containerRepository;
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
        $info['current_movement'] = $container->current_movement;

        $info['in_workorder'] = '';
        $info['in_carrier'] = '';
        $info['in_date'] = '';
        $info['in_content'] = '';

        $info['out_workorder'] = '';
        $info['out_carrier'] = '';
        $info['out_date'] = '';
        $info['out_content'] = '';

        $info['us_workorder'] = '';
        $info['us_date'] = '';
        $info['us_content'] = '';

        $info['st_workorder'] = '';
        $info['st_date'] = '';
        $info['st_content'] = '';               
        // dd($container->workorders->toArray());

        foreach($container->workorders as $workorder) {

            $movement = explode('-', $workorder->movement);

            if($workorder->pivot->confirmed == 1) {

                $confirmed_at = $workorder->pivot->confirmed_at;

                // dd($confirmed_at);

                if($movement[0] == 'HI' || $movement[0] == 'RI') {
                    $info['in_workorder'] = $workorder->id;
                    $info['in_carrier'] = $workorder->getCarrier();
                    $info['in_date'] = $confirmed_at;
                    $info['in_content'] = $workorder->pivot->content;
                }

                if($movement[0] == 'US') {
                    $info['us_workorder'] = $workorder->id;
                    $info['us_date'] = $confirmed_at;
                    $info['us_content'] = $workorder->pivot->content;
                }

                if($movement[0] == 'ST') {
                    $info['st_workorder'] = $workorder->id;
                    $info['st_date'] = $confirmed_at;
                    $info['st_content'] = $workorder->pivot->content;
                }

                if($movement[0] == 'HE' || $movement[0] == 'RO') {
                    $info['out_workorder'] = $workorder->id;
                    $info['out_carrier'] = $workorder->getCarrier();
                    $info['out_date'] = $confirmed_at;
                    $info['out_content'] = $workorder->pivot->content;
                }    
            }       
        }

        return $info;
	}

    public function getValidContainers($input)
    {
        $valid_containers = [];
        $arrays = array_unique(explode(",", $input));

        foreach($arrays as $a) {
            $containerArray = $this->containerRepository->getByContainerNoWithStatus3And4($a);
            // dd($container->container_no);

            foreach($containerArray as $container) {
                if($container) {
                    $valid_containers[] = $container;
                } 
            }

            if(count($containerArray) == 0) {
                $this->containerNotFound[] = $a;
            }            
        }

        return $valid_containers;
    }

}
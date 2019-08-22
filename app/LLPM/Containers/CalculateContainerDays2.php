<?php 
namespace LLPM\Containers;

use Carbon\Carbon;
use LLPM\Repositories\ContainerRepository;

class CalculateContainerDays2
{
    protected $containerRepository;

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
    public function fire($container)
    {
        $days = [];

        $workorders = $container->workorders->sortBy('id');

        // dd(count($workorders));
        // dd($workorders->sortBy('id')->toArray());

        // filter out workorders that are not confirmed yet
        $valid_workorders = $this->filterWorkorders($workorders);

        $total_workorders = count($valid_workorders);

        $days['L'] = 0;
        $days['E'] = 0;

        //get IN workorder
        $woIn = $this->getWoIn($valid_workorders);
        $woOut = $this->getWoOut($valid_workorders);
        $woAct = $this->getWoAct($valid_workorders);

        // dd($woIn->movement);
        // dd($woOut->movement);

        $start_date = Carbon::createFromFormat('Y-m-d H', $woIn->pivot->confirmed_at->format('Y-m-d') . ' 0');

        if($woOut) {
            $end_date = Carbon::createFromFormat('Y-m-d H', $woOut->pivot->confirmed_at->format('Y-m-d') . ' 0');
        } else {
            $end_date =  Carbon::now();
        }

        $actCount = count($woAct);

        // dd($container->container_no . ' | '. $actCount);

        if($actCount == 0) {
            $days[$woIn->pivot->content] += $start_date->diffInDays($end_date) + 1;
        }

        if($actCount == 1) {

            // dd('1');
            $us_date = '';
            $st_date = '';

            $movement = explode('-', $woAct[0]->movement);

            if($movement[0] == 'US') {
                $us_date = Carbon::createFromFormat('Y-m-d H', $woAct[0]->pivot->confirmed_at->format('Y-m-d') . ' 0');

                $days['L'] += $start_date->diffInDays($us_date) + 1;
                $days['E'] += $us_date->diffInDays($end_date) + 1;
            }

            if($movement[0] == 'ST') {
                $st_date = Carbon::createFromFormat('Y-m-d H', $woAct[0]->pivot->confirmed_at->format('Y-m-d') . ' 0');

                $days['E'] += $start_date->diffInDays($st_date) + 1;
                $days['L'] += $st_date->diffInDays($end_date) + 1;            
            }

        }

        if($actCount == 2) {
            $us_date = '';
            $st_date = '';

            foreach($woAct as $wo) {

                $movement = explode('-', $wo->movement);

                if($movement[0] == 'US') {
                    $us_date = Carbon::createFromFormat('Y-m-d H', $wo->pivot->confirmed_at->format('Y-m-d') . ' 0');
                }
                if($movement[0] == 'ST') {
                    $st_date = Carbon::createFromFormat('Y-m-d H', $wo->pivot->confirmed_at->format('Y-m-d') . ' 0');
                }                
            }

            $days['L'] += $start_date->diffInDays($us_date) + 1;   
            $days['E'] += $us_date->diffInDays($st_date) + 1;   
            $days['L'] += $st_date->diffInDays($end_date) + 1;   

        }
        
        $days['total'] = $start_date->diffInDays($end_date) + 1;   

        return $days;
	}

    public function getWoIn($workorders)
    {
        foreach($workorders as $wo) {

            $movement = explode('-', $wo->movement);

            if($movement[0] == 'HI' || $movement[0] == 'RI') {
                return $wo;
            }
        }
    }

    public function getWoOut($workorders)
    {
        foreach($workorders as $wo) {

            $movement = explode('-', $wo->movement);

            if($movement[0] == 'HE' || $movement[0] == 'RO') {
                return $wo;
            }
        }        
    }

    public function getWoAct($workorders)
    {
        $woAct = [];

        foreach($workorders as $wo) {

            $movement = explode('-', $wo->movement);

            if($movement[0] == 'US' || $movement[0] == 'ST') {
                $woAct[] = $wo;
            }
        }

        return $woAct;
    }
    // Only list workorders that have been confirmed
    public function filterWorkorders($workorders)
    {
        $valid_workorders = [];

        foreach($workorders as $workorder) {
            if($workorder->pivot->confirmed == 0) {
                continue;
            }

            $valid_workorders[] = $workorder;
        }

        return $valid_workorders;
    }
}
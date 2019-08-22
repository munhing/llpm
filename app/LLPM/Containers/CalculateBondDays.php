<?php 
namespace LLPM\Containers;

use Carbon\Carbon;
use LLPM\Repositories\ContainerRepository;
use Container;

class CalculateBondDays
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
        $bond_days['import'] = 0;
        $bond_days['export'] = 0;

        // $container = Container::find(188653);
        $workorders = $container->workorders->sortBy('id');


        $valid_workorders = $this->filterWorkorders($workorders);

       
        // calculate bond days for import & export
        $bond_days['import'] = $this->calculateBondImportDays($valid_workorders);
        $bond_days['export'] = $this->calculateBondExportDays($valid_workorders);

        // dd($bond_days);
        return $bond_days;
	}

    public function calculateBondImportDays($workorders)
    {
        $proceedToCalculate = false;

        foreach($workorders as $wo) {
            if($wo->movement == 'HI' && $wo->pivot->content == 'L') {
                $proceedToCalculate = true;

                $date_start = $wo->vesselSchedule->eta;
            }
        }

        if($proceedToCalculate) {

            $date_end = Carbon::now();
            
            foreach($workorders as $wo) {

                $movement = explode('-', $wo->movement);

                if($wo->movement[0] == 'US' || $wo->movement[0] == 'RO') {
                    $date_end = $wo->pivot->confirmed_at;
                }
            }

            return $this->calculateDays($date_start, $date_end);    
        }

        return 0;
    }

    public function calculateBondExportDays($workorders)
    {
        $proceedToCalculate = false;

        foreach($workorders as $wo) {

            $movement = explode('-', $wo->movement);
            // dd($wo);
            if(($movement[0] == 'RI' && $wo->pivot->content == 'L') || ($movement[0] == 'ST' && $wo->pivot->content == 'E')) {

                $proceedToCalculate = true;
                // dd($wo->vessel_schedule_id);

                $date_start = $wo->pivot->confirmed_at;

            }
        }

        if($proceedToCalculate) {

            $date_end = Carbon::now();
            
            foreach($workorders as $wo) {
                if($wo->movement == 'HE') {
                    $date_end = $wo->pivot->confirmed_at;
                }
            }

            return $this->calculateDays($date_start, $date_end);    
        }

        return 0;
    }

    public function calculateDays($date_start, $date_end)
    {
        $start = Carbon::createFromFormat('Y-m-d H', $date_start->format('Y-m-d') . ' 0');
        $end = Carbon::createFromFormat('Y-m-d H', $date_end->format('Y-m-d') . ' 0');

        return $start->diffInDays($end) + 1;
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

        // foreach($valid_workorders as $w) {
        //     var_dump($w->pivot->confirmed);
        // }

        // dd();

        return $valid_workorders;
    }
}
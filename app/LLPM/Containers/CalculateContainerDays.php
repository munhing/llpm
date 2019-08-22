<?php 
namespace LLPM\Containers;

use Carbon\Carbon;
use LLPM\Repositories\ContainerRepository;

class CalculateContainerDays
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


        // If container not confirmed, get date from the creation of the workorder
        if($valid_workorders[0]->pivot->confirmed_at != '0000-00-00 00:00:00') {
            $days['total'] = Carbon::createFromFormat('Y-m-d H', $valid_workorders[0]->pivot->confirmed_at->format('Y-m-d') . ' 0')->diffInDays() + 1;
        } else {
            $days['total'] = Carbon::createFromFormat('Y-m-d H', $valid_workorders[0]->date->format('Y-m-d') . ' 0')->diffInDays() + 1;
        }

        // echo 'Valid Workorders: ' . "\n" . json_encode($valid_workorders) . "\n" . "\n";
        // echo 'Total Workorders: ' . json_encode($total_workorders) . "\n" . "\n";


        for($i=0; $i<$total_workorders; $i++) {

            // echo 'Workorder #: ' . $valid_workorders[$i]->id . "\n" . "\n";

            // reason for creating a new carbon so that it will capture the date and not the time.
            // Carbon diffInDays() compute 0 if less than 24 hours
            if($valid_workorders[$i]->pivot->confirmed_at != '0000-00-00 00:00:00') {
                $fromDate = Carbon::createFromFormat('Y-m-d H', $valid_workorders[$i]->pivot->confirmed_at->format('Y-m-d') . ' 0');
            } else {
                $fromDate = Carbon::createFromFormat('Y-m-d H', $valid_workorders[$i]->date->format('Y-m-d') . ' 0');
            }

            // dd($fromDate);

            $movement = $valid_workorders[$i]->pivot->movement;

            $content = $valid_workorders[$i]->pivot->content;

            if($movement == 'US') {
                $content = 'E';
            } elseif($movement == 'ST') {
                $content = 'L';
            }

            $arr_movement = explode('-', $movement);
            // dd($arr_movement[0]);

            if($i+1 == $total_workorders) {
                if($arr_movement[0] == 'HE' || $arr_movement[0] == 'RO'){
                    if($valid_workorders[$i]->pivot->confirmed_at != '0000-00-00 00:00:00') {
                        $toDate = Carbon::createFromFormat('Y-m-d H', $valid_workorders[$i]->pivot->confirmed_at->format('Y-m-d') . ' 0');
                    } else {
                        $toDate = Carbon::createFromFormat('Y-m-d H', $valid_workorders[$i]->date->format('Y-m-d') . ' 0');
                    }

                    if($valid_workorders[0]->pivot->confirmed_at != '0000-00-00 00:00:00') {
                        if($valid_workorders[$i]->pivot->confirmed_at != '0000-00-00 00:00:00') {
                            $days['total'] = Carbon::createFromFormat('Y-m-d H', $valid_workorders[0]->pivot->confirmed_at->format('Y-m-d') . ' 0')->diffInDays(Carbon::createFromFormat('Y-m-d H', $valid_workorders[$i]->pivot->updated_at->format('Y-m-d') . ' 0')) + 1;
                        }else {
                            $days['total'] = Carbon::createFromFormat('Y-m-d H', $valid_workorders[0]->pivot->confirmed_at->format('Y-m-d') . ' 0')->diffInDays(Carbon::createFromFormat('Y-m-d H', $valid_workorders[$i]->date->format('Y-m-d') . ' 0')) + 1;
                        }
                    } else {
                        if($valid_workorders[$i]->pivot->confirmed_at != '0000-00-00 00:00:00') {
                            $days['total'] = Carbon::createFromFormat('Y-m-d H', $valid_workorders[0]->date->format('Y-m-d') . ' 0')->diffInDays(Carbon::createFromFormat('Y-m-d H', $valid_workorders[$i]->pivot->updated_at->format('Y-m-d') . ' 0')) + 1;
                        } else {
                            $days['total'] = Carbon::createFromFormat('Y-m-d H', $valid_workorders[0]->date->format('Y-m-d') . ' 0')->diffInDays(Carbon::createFromFormat('Y-m-d H', $valid_workorders[$i]->date->format('Y-m-d') . ' 0')) + 1;
                        }
                    }

                } else {
                    $toDate = Carbon::now();
                } 
            } else {
                if($valid_workorders[$i+1]->pivot->confirmed_at != '0000-00-00 00:00:00') {
                    $toDate = Carbon::createFromFormat('Y-m-d H', $valid_workorders[$i+1]->pivot->confirmed_at->format('Y-m-d') . ' 0');
                } else {
                    $toDate = Carbon::createFromFormat('Y-m-d H', $valid_workorders[$i+1]->date>format('Y-m-d') . ' 0');
                }
            }

            $diffDays = $fromDate->diffInDays($toDate);

            // if this is the last workorder, then add 1 day
            // if the next workorder is US/ST, then have to add 1 day
            if($i+1 == $total_workorders) {
                $diffDays += 1;
            } else {
                $next_movement = $valid_workorders[$i+1]->pivot->movement;
         
                if($next_movement == 'US' || $next_movement == 'ST'){
                    $diffDays += 1;
                }
            }

            $days[$content] += $diffDays;

            // echo 'FromDate : ' . $fromDate . "\n" . "\n";
            // echo 'ToDate : ' . $toDate . "\n" . "\n";
            // echo 'movement : ' . $movement . "\n" . "\n";
            // echo 'Content : ' . $content . "\n" . "\n";
        }

        return $days;
	}

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
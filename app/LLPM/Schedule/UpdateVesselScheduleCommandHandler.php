<?php namespace LLPM\Schedule;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\VesselScheduleRepository;
use VesselSchedule;

class UpdateVesselScheduleCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $vesselScheduleRepository;

	function __construct(VesselScheduleRepository $vesselScheduleRepository)
	{
		$this->vesselScheduleRepository = $vesselScheduleRepository;
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

		$vesselSchedule = VesselSchedule::edit(
			$command->schedule_id,
	        $command->vessel_id,
	        $command->portuser_id,
	        $command->voyage_no_arrival,
	        $command->voyage_no_departure,
	        $command->eta,
	        $command->etd,
	        $command->mt_arrival,
	        $command->mt_departure, 
	        $command->m3_arrival,
	        $command->m3_departure 
		);

		$this->vesselScheduleRepository->save($vesselSchedule);

		$this->dispatchEventsFor($vesselSchedule);

		return $vesselSchedule;
    }

}
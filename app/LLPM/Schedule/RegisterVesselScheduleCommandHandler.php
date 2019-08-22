<?php 

namespace LLPM\Schedule;

use LLPM\IdGenerator;
use LLPM\Repositories\VesselScheduleRepository;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use VesselSchedule;

class RegisterVesselScheduleCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $vesselScheduleRepository;
	protected $idGenerator;

	function __construct(VesselScheduleRepository $vesselScheduleRepository, IdGenerator $idGenerator)
	{
		$this->vesselScheduleRepository = $vesselScheduleRepository;
		$this->idGenerator = $idGenerator;
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
    	$registered_vessel_id = $this->idGenerator->generateVesselId();

		$vesselSchedule = VesselSchedule::register(
			$registered_vessel_id,
			$command->vessel_id,
			$command->voyage_no_arrival,
			$command->portuser_id,
			$command->eta,
			$command->etd
		);

		$this->vesselScheduleRepository->save($vesselSchedule);

		$this->dispatchEventsFor($vesselSchedule);

		return $vesselSchedule;
    }

}
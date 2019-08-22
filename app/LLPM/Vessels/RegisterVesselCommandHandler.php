<?php namespace LLPM\Vessels;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\VesselRepository;
use Vessel;

class RegisterVesselCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $vesselRepository;

	function __construct(VesselRepository $vesselRepository)
	{
		$this->vesselRepository = $vesselRepository;
	}
    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {
		$vessel = Vessel::register(
			$command->name
		);

		$this->vesselRepository->save($vessel);

		$this->dispatchEventsFor($vessel);

		return $vessel;
    }

}
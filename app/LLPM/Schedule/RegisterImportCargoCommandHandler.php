<?php namespace LLPM\Schedule;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\CommanderTrait;

use LLPM\Repositories\CargoRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\Schedule\RegisterImportContainersCommand;
use Cargo;

class RegisterImportCargoCommandHandler implements CommandHandler {

	use DispatchableTrait;
	use CommanderTrait;

	protected $cargoRepository;
	protected $containerRepository;

	function __construct(CargoRepository $cargoRepository, ContainerRepository $containerRepository)
	{
		$this->cargoRepository = $cargoRepository;
		$this->containerRepository = $containerRepository;
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

		$importCargo = Cargo::register(
			$command->bl_no,
			$command->consignor_id, 
			$command->consignee_id,
			$command->mt, 
			$command->m3,
			1,
			$command->description,
			$command->markings,
            $command->import_vessel_schedule_id,
            $command->receiving_id		
		);

		$this->cargoRepository->save($importCargo);

		return $importCargo;    	
    }

}
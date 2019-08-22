<?php namespace LLPM\Receiving;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\CommanderTrait;

use LLPM\Repositories\CargoRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\Receiving\RegisterReceivingContainersCommand;

use Cargo;

class RegisterExportCargoCommandHandler implements CommandHandler {

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
    	// dd($command);

		$exportCargo = Cargo::registerExport(
			$command->bl_no,
			$command->consignor_id, 
			$command->consignee_id,
			$command->mt, 
			$command->m3,
			1,
			$command->description,
			$command->markings,
            $command->export_vessel_schedule_id,
            $command->receiving_id		
		);

		$this->cargoRepository->save($exportCargo);

		return $exportCargo;   	
    }

}
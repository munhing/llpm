<?php namespace LLPM\Schedule;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\CommanderTrait;

use LLPM\Repositories\CargoRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\Schedule\RegisterImportContainersCommand;
use Cargo;


class UpdateImportCargoCommandHandler implements CommandHandler {

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

		$importCargo = Cargo::edit(
			$command->cargo_id,
			$command->bl_no,
			$command->consignor_id, 
			$command->consignee_id,
			$command->mt, 
			$command->m3, 
			$command->description,
			$command->markings,
			$command->country_code,
			$command->port_code,
			$command->custom_reg_no,
			$command->custom_form_no,
            $command->import_vessel_schedule_id,
            $command->receiving_id				

		);

		$this->cargoRepository->save($importCargo);

		// if($command->containers) {	

		// 	$this->execute(RegisterImportContainersCommand::class, [
		// 		'containers' => $command->containers, 
		// 		'import_vessel_schedule_id' => $command->import_vessel_schedule_id, 
		// 		'receiving_id' => $command->receiving_id
		// 	]);

		// 	foreach($command->containers as $container) {

		// 		$c = $this->containerRepository->getActiveByContainerNo($container->container_no);

		// 		$this->cargoRepository->attachToContainer($importCargo, $c);
				
		// 		$c->content = 'L';
		// 		$c->save();
		// 	}			
		// }
		//$this->dispatchEventsFor($importCargo);

		return $importCargo;    	
    }

}
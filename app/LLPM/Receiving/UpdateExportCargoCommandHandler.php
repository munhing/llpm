<?php namespace LLPM\Receiving;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\CommanderTrait;

use LLPM\Repositories\CargoRepository;
use LLPM\Repositories\ContainerRepository;
use Cargo;


class UpdateExportCargoCommandHandler implements CommandHandler {

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

		$cargo = Cargo::editExport(
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
			$command->custom_form_no
		);

		$this->cargoRepository->save($cargo);

		return $cargo;    	
    }

}
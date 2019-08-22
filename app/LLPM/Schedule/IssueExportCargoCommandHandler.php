<?php namespace LLPM\Schedule;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\CargoRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\IdGenerator;
use Carbon\Carbon;
use Cargo;
use Auth;
use ExportDL;

class IssueExportCargoCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $cargoRepository;
	protected $containerRepository;
	protected $idGenerator;

	function __construct(CargoRepository $cargoRepository, ContainerRepository $containerRepository, IdGenerator $idGenerator)
	{
		$this->cargoRepository = $cargoRepository;
		$this->containerRepository = $containerRepository;
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
    	//generate DL number
    	// should be done by a specific class
    	$exportDL = ExportDL::register($command->cargo_id);

    	$dl_no = $exportDL->id;

    	//update import cargo's dl_no
		// $cargo = Cargo::issue(
		// 	$command->cargo_id,
		// 	$dl_no
		// );

		// $this->cargoRepository->save($cargo);
		// $cargo->increment('status');

    	$cargo = $this->cargoRepository->getById($command->cargo_id);

		$cargo->increment('status');

		$cargo->dl_no = $dl_no;
		$cargo->issued_by = Auth::user()->id;
		$cargo->issued_date = Carbon::now();

		$cargo->save();


		if($cargo->containerized > 0) {

			foreach($cargo->containers as $container)
			{
				$change = true;

				foreach($this->containerRepository->getById($container->id)->cargoes as $crg)
				{
					if($crg->dl_no == 0) {
						$change = false;
					}		
				}

				if($change) {

					// update container->dl_check = 0
					$container->dl_check = 0;
					$container->save();
				}
			}
		}

		return $cargo;    	
    }

}
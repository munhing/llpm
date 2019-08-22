<?php namespace LLPM\Schedule;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\CargoRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\IdGenerator;
use Carbon\Carbon;
use Auth;
use ImportDL;

class IssueImportCargoCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $cargoRepository;
	protected $containerRepository;
	protected $idGenerator;

	function __construct(
		CargoRepository $cargoRepository, 
		ContainerRepository $containerRepository, 
		IdGenerator $idGenerator
	)
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
    	// generate DL number
    	$importDL = ImportDL::register($command->cargo_id);

    	$dl_no = $importDL->id;

    	$cargo = $this->cargoRepository->getById($command->cargo_id);

    	$cargo = $this->updateCargoWithDlNo($cargo, $dl_no);

    	// if containerized cargo, process containers for release
		if($cargo->containerized > 0) {
			
			// Rule Option 1: All cargoes must be issued DL before container can be release
			// $this->processAssociatedContainersOption1($cargo);

			// Rule Option 2: At least one cargo must be issued DL before container can be release
			$this->processAssociatedContainersOption2($cargo);
		}
	
		return $cargo;    	
    }

    public function updateCargoWithDlNo($cargo, $dl_no)
    {
		$cargo->increment('status');

		$cargo->dl_no = $dl_no;
		$cargo->issued_by = Auth::user()->id;
		$cargo->issued_date = Carbon::now();

		$cargo->save();

		return $cargo;
    }

    public function processAssociatedContainersOption1($cargo)
    {
		//Loop thru all associated containers
		foreach($cargo->containers as $container)
		{
			if($this->processAssociatedCargoes($container)) {
				// update container->dl_check = 0
				$this->updateContainerForRelease($container);
			}
		}
    }

    public function processAssociatedContainersOption2($cargo)
    {
		//Loop thru all associated containers
		foreach($cargo->containers as $container) {
			$this->updateContainerForRelease($container);
		}
    }

    public function processAssociatedCargoes($container)
    {
		// Loop thru all associated cargoes
		// If 1 cargo have not been issued DL, return immediately with false.
		foreach($this->containerRepository->getById($container->id)->cargoes as $crg) {
			if($crg->dl_no == 0) {
				return false;
			}		
		}

		return true;
    }

    public function updateContainerForRelease($container)
    {
		$container->dl_check = 0;
		$container->save();   	
    }

}
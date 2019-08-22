<?php

use LLPM\Repositories\CargoRepository;

use LLPM\CargoConfirmation\CargoConfirmationCommand;
use LLPM\CargoConfirmation\CargoExportConfirmationCommand;

class CargoConfirmationController extends \BaseController {

	protected $cargoRepository;

	function __construct(CargoRepository $cargoRepository)
	{
		parent::__construct();
		$this->cargoRepository = $cargoRepository;
	}

	/**
	 * Display a listing of the resource.
	 * GET /cargoconfirmation
	 *
	 * @return Response
	 */
	public function indexImport()
	{

		$cargoes = $this->cargoRepository->getImportLooseCargoWithStatus1And3();

		// dd($cargoes->toArray());

        // foreach($cargoes as $crg) {

        //     var_dump($crg->importSchedule->vessel);
        // }

        // die();

		return View::make('cargo_confirmation/index', compact('cargoes'))->withAccess($this->access);		
	}


	public function indexExport()
	{
		// return "CargoConfiration";
		$cargoes = $this->cargoRepository->getExportLooseCargoWithStatus2And3();

        // foreach($cargoes as $crg) {

        //     var_dump(DB::getQueryLog());
        //     var_dump($crg->exportSchedule);
        // }


        // die();

		return View::make('cargo_confirmation/cargo_export', compact('cargoes'))->withAccess($this->access);	
	}


	public function updateImport()
	{
		$input = Input::all();
		
		// dd($input);

		if(! isset($input['confirmationId'])) {

			Flash::error("No cargoes selected!");
			return Redirect::back();			
		}

		$this->execute(CargoConfirmationCommand::class, $input);

		Flash::success('Confirmation successful!');

		return Redirect::route('cargo.confirmation.import');		
	}

	public function updateExport()
	{
		// dd(Input::all());

		$input = Input::all();

		if(! isset($input['confirmationId'])) {

			Flash::error("No cargoes selected!");
			return Redirect::back();			
		}

		//dd('Stop');

		$this->execute(CargoExportConfirmationCommand::class, $input);

		Flash::success('Confirmation successful!');

		return Redirect::route('cargo.confirmation.export');		
	}	

}
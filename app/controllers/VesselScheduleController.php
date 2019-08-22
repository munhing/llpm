<?php

use LLPM\ContainerHelper;
use LLPM\Forms\CargoItemForm;
use LLPM\Forms\ImportCargoForm;
use LLPM\Forms\VesselScheduleForm;
use LLPM\Forms\ContainerForm;
use LLPM\Repositories\CargoItemRepository;
use LLPM\Repositories\CargoRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\CountryRepository;
use LLPM\Repositories\PortUserRepository;
use LLPM\Repositories\VesselRepository;
use LLPM\Repositories\VesselScheduleRepository;
use LLPM\Schedule\AddItemToCargoCommand;
use LLPM\Schedule\AssociateContainersWithCargoCommand;
use LLPM\Schedule\DeleteImportContainerCommand;
use LLPM\Schedule\DeleteCargoCommand;
use LLPM\Schedule\DetachContainerFromCargoCommand;
use LLPM\Schedule\IssueExportCargoCommand;
use LLPM\Schedule\IssueImportCargoCommand;
use LLPM\Schedule\RegisterImportCargoCommand;
use LLPM\Schedule\RegisterImportContainersCommand;
use LLPM\Schedule\RegisterVesselScheduleCommand;
use LLPM\Schedule\UpdateExportCargoCommand;
use LLPM\Schedule\UpdateImportCargoCommand;
use LLPM\Schedule\UpdateCargoItemCommand;
use LLPM\Schedule\UpdateVesselScheduleCommand;
use LLPM\Schedule\UpdateContainerCommand;
use LLPM\Schedule\UnlinkContainerCommand;

class VesselScheduleController extends \BaseController {

	protected $vesselScheduleRepository;
	protected $vesselRepository;
	protected $containerRepository;
	protected $cargoRepository;
	protected $cargoItemRepository;
	protected $portUserRepository;
	protected $countryRepository;
	protected $vesselScheduleForm;
	protected $importCargoForm;
	protected $cargoItemForm;
	protected $containerForm;

	use ContainerHelper;

	function __construct(
		VesselScheduleRepository $vesselScheduleRepository,
		VesselRepository $vesselRepository,
		ContainerRepository $containerRepository,
		CargoRepository $cargoRepository,
		CargoItemRepository $cargoItemRepository,
		PortUserRepository $portUserRepository,
		CountryRepository $countryRepository,
		VesselScheduleForm $vesselScheduleForm,
		ImportCargoForm $importCargoForm,
		CargoItemForm $cargoItemForm,
		ContainerForm $containerForm
	)
	{
		parent::__construct();
		$this->vesselScheduleRepository = $vesselScheduleRepository;
		$this->vesselRepository = $vesselRepository;
		$this->containerRepository = $containerRepository;
		$this->cargoRepository = $cargoRepository;
		$this->cargoItemRepository = $cargoItemRepository;
		$this->portUserRepository = $portUserRepository;
		$this->countryRepository = $countryRepository;
		$this->vesselScheduleForm = $vesselScheduleForm;
		$this->importCargoForm = $importCargoForm;
		$this->containerForm = $containerForm;

		$this->cargoItemForm = $cargoItemForm;
	}


	/**
	 * Display a listing of the resource.
	 * GET /vesselschedule
	 *
	 * @return Response
	 */
	public function index()
	{
		//get date from session or get default
		//dd(Session::get('view_date'));

		//dd(Input::get('view_date'));
		if(Input::get('view_date')) {
			Session::put('view_date', Input::get('view_date'));
		}

		if(!Session::get('view_date')) {
			Session::put('view_date', date('m/Y'));
		}

		$vesselSchedule = $this->vesselScheduleRepository->getAllByMonth(convertMonthToMySQLDate(Session::get('view_date')));
		return View::make('schedule/index', compact('vesselSchedule'))->withAccess($this->access);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /vesselschedule/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$vessels = $this->vesselRepository->getAll()->lists('name', 'id');
		$portUsers = $this->portUserRepository->getAll()->lists('name', 'id');
		return View::make('schedule/create', compact('vessels', 'portUsers'))->withAccess($this->access);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /vesselschedule
	 *
	 * @return Response
	 */
	public function store()
	{

		$this->vesselScheduleForm->validate(Input::all());

		$vesselSchedule = $this->execute(RegisterVesselScheduleCommand::class);

		//dd($vesselSchedule->vessel->name);

		Flash::success("Vessel Schedule for ".$vesselSchedule->vessel->name." has been registered!");

		return Redirect::route('manifest.schedule');
	}

	/**
	 * Display the specified resource.
	 * GET /vesselschedule/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showImport($id)
	{
		$vesselSchedule = $this->vesselScheduleRepository->getDetailsById($id);

		//Get list of containers that has not discharge yet
		$containers_status1 = $this->containerRepository->getContainersStatus1ByVessel($id)->lists('container_no');

		// dd($containers_status1->lists('container_no'));
		return View::make('schedule/show_import', compact('vesselSchedule', 'containers_status1'))->withAccess($this->access);
	}

	public function showExport($id)
	{
		$vesselSchedule = $this->vesselScheduleRepository->getDetailsById($id);

		//Get list of containers that has not loaded yet
		$containers_status3 = $this->containerRepository->getContainersStatus3ByVessel($id)->lists('container_no');

		//dd($vesselSchedule->toArray());
		return View::make('schedule/show_export', compact('vesselSchedule', 'containers_status3'))->withAccess($this->access);
	}
	/**
	 * Show the form for editing the specified resource.
	 * GET /vesselschedule/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$vesselSchedule = $this->vesselScheduleRepository->getById($id);
		//dd($vesselSchedule->id);
		$vessels = $this->vesselRepository->getAll()->lists('name', 'id');
		$portUsers = $this->portUserRepository->getAll()->lists('name', 'id');

		// dd($portUsers);
		return View::make('schedule/edit', compact('vesselSchedule', 'vessels', 'portUsers'))->withAccess($this->access);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /vesselschedule/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		
		$this->vesselScheduleForm->validate(Input::all());

		$vesselSchedule = $this->execute(UpdateVesselScheduleCommand::class);

		Flash::success("Vessel Schedule for ".$vesselSchedule->vessel->name." has been updated!");

		return Redirect::route('manifest.schedule');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /vesselschedule/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function createImportContainer($id)
	{
		$schedule = $this->vesselScheduleRepository->getById($id);
		
		//dd($schedule->toArray());
		return View::make('schedule/create_import_container', compact('schedule'))->withAccess($this->access);
	}

	// Create Empty Import Containers
	public function storeImportContainer($id)
	{
		$input = Input::all();
		$input['import_vessel_schedule_id'] = $id;
		$input['receiving_id'] = 0;

		// filterContainers(containers in string, $content, $status)
		$input['containers'] = $this->filterContainers($input['containers'], 'E', 1);

		if(! $input['containers']) {

			Flash::error("Please key in correctly!");
			return Redirect::back();			
		}

		$importContainers = $this->execute(RegisterImportContainersCommand::class, $input);

		Flash::success("Containers successfully registered!");
		
		if(!$importContainers){
			Flash::error("No Containers were registered!");	
		}

		return Redirect::route('manifest.schedule.import', $id);

	}

	public function editContainer()
	{
		$input = Input::all();

		$this->containerForm->validate(Input::all());

		$container = $this->execute(UpdateContainerCommand::class, $input);

		// dd($input);
		Flash::success("Container No: ". $container->container_no ." was updated!");

		return Redirect::back();
	}

	public function destroyImportContainer($schedule_id)
	{
		$input = Input::all();

		$container = $this->execute(DeleteImportContainerCommand::class, $input);

		Flash::success("Container No: ". $container->container_no ." was removed!");

		return Redirect::back();	
	}

	public function showImportCargo($id, $cargo_id)
	{

		//dd('Hello');
		$importCargo = $this->cargoRepository->getImportById($cargo_id);
		$importCargoItems = $this->cargoItemRepository->getAllByCargoId($cargo_id);

		//dd($importCargoItems->toArray());

		//dd($importCargo->m_containers);
		$schedule = $this->vesselScheduleRepository->getById($id);

		return View::make('schedule/show_import_cargo', compact('importCargo', 'importCargoItems', 'schedule'))->withAccess($this->access);
	}

	public function generateDLImportCargo($id, $cargo_id)
	{

		$importCargo = $this->cargoRepository->getImportById($cargo_id);

		//dd($importCargoItems->toArray());
		$schedule = $this->vesselScheduleRepository->getById($id);

		//dd($schedule->toArray());
		return View::make('schedule/generate_dl_import', compact('importCargo', 'schedule'))->withAccess($this->access);
	}

	public function showExportCargo($id, $cargo_id)
	{

		//dd('Hello');
		$cargo = $this->cargoRepository->getImportById($cargo_id);
		$cargoItems = $this->cargoItemRepository->getAllByCargoId($cargo_id);

		//dd($importCargoItems->toArray());
		$schedule = $this->vesselScheduleRepository->getById($id);

		return View::make('schedule/show_export_cargo', compact('cargo', 'cargoItems', 'schedule'))->withAccess($this->access);
	}	

	public function generateDLExportCargo($id, $cargo_id)
	{

		$cargo = $this->cargoRepository->getImportById($cargo_id);

		//dd($importCargoItems->toArray());
		$schedule = $this->vesselScheduleRepository->getById($id);

		//dd($schedule->toArray());
		return View::make('schedule/generate_dl_export', compact('cargo', 'schedule'))->withAccess($this->access);
	}

	public function createImportCargo($id)
	{
		$schedule = $this->vesselScheduleRepository->getById($id);
		$portUsers = $this->portUserRepository->getAll()->lists('name', 'id');

		//dd($schedule->toArray());
		return View::make('schedule/create_import_cargo', compact('schedule', 'portUsers'))->withAccess($this->access);
	}	

	public function storeImportCargo($id)
	{

		$input = Input::all();
		$input['import_vessel_schedule_id'] = $id;
		$input['receiving_id'] = 0;

		$import_vessel_schedule_id = $id;

		// filterContainers(containers in string, $content, $status)
		//$input['containers'] = $this->filterContainers($input['containers'], 'L', 1);

		$this->importCargoForm->validateRegister($input, $import_vessel_schedule_id, 'import_vessel_schedule_id');

		$importCargo = $this->execute(RegisterImportCargoCommand::class, $input);

		Flash::success("Cargo with B/L No: ".$importCargo->bl_no." has been registered!");

		return Redirect::route('manifest.schedule.import', $id);
	}

	public function editImportCargo($id, $cargo_id)
	{
		$schedule = $this->vesselScheduleRepository->getById($id);
		$cargo = $this->cargoRepository->getImportById($cargo_id);
		$portUsers = $this->portUserRepository->getAll()->lists('name', 'id');
		$country = [null => "Please select a country"] + $this->countryRepository->getAll()->lists('name', 'iso');
		//dd($country);

		//dd($schedule->toArray());
		return View::make('schedule/edit_import_cargo', compact('schedule', 'portUsers', 'cargo', 'country'))->withAccess($this->access);
	}	

	public function deleteCargo($schedule_id)
	{
		$input = Input::all();

		// dd($input);

		$cargo = $this->execute(DeleteCargoCommand::class, $input);

		if(! $cargo) {
			Flash::error("There are items registered to this cargo. Kindly delete all items first before you can delete this cargo.");
			return Redirect::back();
		}

		Flash::success("Cargo with B/L No: ".$cargo->bl_no." has been deleted!");

		return Redirect::back();
	}

	public function editExportCargo($id, $cargo_id)
	{
		$schedule = $this->vesselScheduleRepository->getById($id);
		$cargo = $this->cargoRepository->getImportById($cargo_id);
		$portUsers = $this->portUserRepository->getAll()->lists('name', 'id');
		$country = [null => "Please select a country"] + $this->countryRepository->getAll()->lists('name', 'iso');
		//dd($country);

		//dd($schedule->toArray());
		return View::make('schedule/edit_export_cargo', compact('schedule', 'portUsers', 'cargo', 'country'))->withAccess($this->access);
	}	

	public function updateImportCargo($id, $cargo_id)
	{
		$input = Input::all();
		$input['import_vessel_schedule_id'] = $id;
		$input['receiving_id'] = 0;

		$import_vessel_schedule_id = $id;
		
		//$input['containers'] = $this->filterContainers($input['containers'], 'L', 1);

		$this->importCargoForm->validateUpdate($input, $cargo_id, $import_vessel_schedule_id, 'import_vessel_schedule_id');
		// dd($input);
		$importCargo = $this->execute(UpdateImportCargoCommand::class, $input);

		//$this->registerImportContainers($input, $importCargo);

		Flash::success("Cargo with B/L No: ".$importCargo->bl_no." has been updated!");

		return Redirect::route('manifest.schedule.import.cargoes.show', [$id, $cargo_id]);
	}	

	public function updateExportCargo($id, $cargo_id)
	{
		$input = Input::all();
		$input['export_vessel_schedule_id'] = $id;

		$export_vessel_schedule_id = $id;
		// dd($input);

		//$input['containers'] = $this->filterContainers($input['containers'], 'L', 1);

		// $this->importCargoForm->validateUpdate($input, $cargo_id);
		$this->importCargoForm->validateUpdate($input, $cargo_id, $export_vessel_schedule_id, 'export_vessel_schedule_id');

		$cargo = $this->execute(UpdateExportCargoCommand::class, $input);

		//$this->registerImportContainers($input, $importCargo);

		Flash::success("Cargo with B/L No: ".$cargo->bl_no." has been updated!");

		return Redirect::route('manifest.schedule.export.cargoes.show', [$id, $cargo_id]);
	}	

	public function editImportCargoItem($schedule_id, $cargo_id, $cargo_item_id)
	{
		$schedule = $this->vesselScheduleRepository->getById($schedule_id);
		$cargo = $this->cargoRepository->getImportById($cargo_id);
		$cargoItem = $this->cargoItemRepository->getById($cargo_item_id);
		//dd($cargoItem->toArray());
		return View::make('schedule/edit_import_cargo_item', compact('schedule', 'cargo', 'cargoItem'))->withAccess($this->access);
	}	

	public function editExportCargoItem($schedule_id, $cargo_id, $cargo_item_id)
	{
		$schedule = $this->vesselScheduleRepository->getById($schedule_id);
		$cargo = $this->cargoRepository->getImportById($cargo_id);
		$cargoItem = $this->cargoItemRepository->getById($cargo_item_id);
		//dd($cargoItem->toArray());
		return View::make('schedule/edit_export_cargo_item', compact('schedule', 'cargo', 'cargoItem'))->withAccess($this->access);
	}

	public function updateImportCargoItem($schedule_id, $cargo_id)
	{
		$input = Input::all();

		// dd($input);

		$input['schedule_id'] = $schedule_id;
		$input['cargo_id'] = $cargo_id;
		
		$this->cargoItemForm->validate($input);

		$importCargo = $this->execute(UpdateCargoItemCommand::class, $input);

		//$this->registerImportContainers($input, $importCargo);

		Flash::success("Item successfully updated!");

		return Redirect::route('manifest.schedule.import.cargoes.show', [$schedule_id, $cargo_id]);
	}	

	public function updateExportCargoItem($schedule_id, $cargo_id)
	{
		$input = Input::all();


		$input['schedule_id'] = $schedule_id;
		$input['cargo_id'] = $cargo_id;
		
		// dd($input);
		
		$this->cargoItemForm->validate($input);

		$importCargo = $this->execute(UpdateCargoItemCommand::class, $input);

		//$this->registerImportContainers($input, $importCargo);

		Flash::success("Item successfully updated!");

		return Redirect::route('manifest.schedule.export.cargoes.show', [$schedule_id, $cargo_id]);
	}	

	public function addContainerToCargo($schedule_id, $cargo_id)
	{
		$input = Input::all();
		$input['import_vessel_schedule_id'] = $schedule_id;
		$input['cargo_id'] = $cargo_id;
		$input['containers'] = $this->filterContainers($input['containers'], 'L', 1);

		if(!$input['containers']){
			Flash::error("No Containers were registered!");	
			return Redirect::back();
		}

		$messages = $this->execute(AssociateContainersWithCargoCommand::class, $input);

		return Redirect::back()->with('infos', $messages->all());

	}

	public function addItemToCargo($schedule_id, $cargo_id)
	{
		$input = Input::all();

		$input['cargo_id'] = $cargo_id;
		
		$this->cargoItemForm->validate($input);

		$this->execute(AddItemToCargoCommand::class, $input);

		Flash::success("Item has been registered!");

		return Redirect::route('manifest.schedule.import.cargoes.show', [$schedule_id, $cargo_id]);

	}

	public function addItemToCargoExport($schedule_id, $cargo_id)
	{
		$input = Input::all();

		$input['cargo_id'] = $cargo_id;
		
		$this->cargoItemForm->validate($input);

		// dd($input);

		$this->execute(AddItemToCargoCommand::class, $input);

		Flash::success("Item has been registered!");

		return Redirect::route('manifest.schedule.export.cargoes.show', [$schedule_id, $cargo_id]);

	}

	public function issueImportCargo($id, $cargo_id)
	{
		$input['vessel_schedule_id'] = $id;
		$input['cargo_id'] = $cargo_id;

		$this->execute(IssueImportCargoCommand::class, $input);

		Flash::success("DL has been issued!");

		return Redirect::back();
	}

	public function issueExportCargo($id, $cargo_id)
	{
		
		$input = Input::all();
		$input['vessel_schedule_id'] = $id;
		$input['cargo_id'] = $cargo_id;

		//dd($input);

		$this->execute(IssueExportCargoCommand::class, $input);

		Flash::success("DL has been issued!");

		return Redirect::back();
	}

	public function detachImportCargo($schedule_id, $cargo_id)
	{
		$input = Input::all();
		$input['schedule_id'] = $schedule_id;
		$input['cargo_id'] = $cargo_id;
		
		$messages = $this->execute(DetachContainerFromCargoCommand::class, $input);

		return Redirect::back()->with('infos', $messages->all());			
	}

	public function searchByVesselId()
	{
		$vessel_id = Input::get('vessel_id');
		$schedule = $this->vesselScheduleRepository->getByVesselId($vessel_id);
		return json_encode($schedule);
	}

	public function unlinkContainer($schedule_id, $cargo_id)
	{
		$input = Input::all();
		$input['cargo_id'] = $cargo_id;

		// dd($input);

		$container = $this->execute(UnlinkContainerCommand::class, $input);

		Flash::success("Container No: ". $container->container_no ." was unlinked!");

		return Redirect::back();			
	}

}
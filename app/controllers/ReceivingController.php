<?php

use LLPM\ContainerHelper;
use LLPM\Forms\CargoItemForm;
use LLPM\Forms\ImportCargoForm;
use LLPM\Forms\ContainerForm;
use LLPM\Receiving\AssociateContainersWithCargoCommand;
use LLPM\Receiving\DeleteReceivingContainerCommand;
use LLPM\Receiving\IssueExportCargoCommand;
use LLPM\Receiving\RegisterExportCargoCommand;
use LLPM\Receiving\RegisterReceivingContainersCommand;
use LLPM\Receiving\UnlinkReceivingContainerCommand;
use LLPM\Receiving\UpdateExportCargoCommand;
use LLPM\Repositories\CargoItemRepository;
use LLPM\Repositories\CargoRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\CountryRepository;
use LLPM\Repositories\PortUserRepository;
use LLPM\Repositories\ReceivingRepository;
use LLPM\Repositories\VesselScheduleRepository;
use LLPM\Schedule\AddItemToCargoCommand;
use LLPM\Schedule\UpdateCargoItemCommand;
use LLPM\Schedule\UpdateContainerCommand;

class ReceivingController extends \BaseController {

	protected $receivingRepository;
	protected $portUserRepository;
	protected $vesselScheduleRepository;
	protected $containerRepository;
	protected $cargoRepository;
	protected $cargoItemRepository;
	protected $countryRepository;
	protected $importCargoForm;
	protected $cargoItemForm;
	protected $containerForm;

	use ContainerHelper;

	function __construct(
		ReceivingRepository $receivingRepository,
		PortUserRepository $portUserRepository,
		VesselScheduleRepository $vesselScheduleRepository,
		ImportCargoForm $importCargoForm,
		ContainerRepository $containerRepository,
		CargoRepository $cargoRepository,
		CargoItemRepository $cargoItemRepository,
		CountryRepository $countryRepository,
		CargoItemForm $cargoItemForm,
		ContainerForm $containerForm
	)
	{
		parent::__construct();
		$this->receivingRepository = $receivingRepository;
		$this->portUserRepository = $portUserRepository;
		$this->vesselScheduleRepository = $vesselScheduleRepository;
		$this->containerRepository = $containerRepository;
		$this->cargoRepository = $cargoRepository;
		$this->cargoItemRepository = $cargoItemRepository;
		$this->countryRepository = $countryRepository;

		$this->importCargoForm = $importCargoForm;
		$this->cargoItemForm = $cargoItemForm;
		$this->containerForm = $containerForm;
	}
	/**
	 * Display a listing of the resource.
	 * GET /receiving
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Input::get('view_date')) {
			Session::put('receiving.date', Input::get('view_date'));
		}

		if(!Session::get('receiving.date')) {
			Session::put('receiving.date', date('m/Y'));
		}

		// dd(Session::get('receiving.date'));

		$receiving = $this->receivingRepository->getAllByMonth(convertMonthToMySQLDate(Session::get('receiving.date')));
		return View::make('receiving/index', compact('receiving'))->withAccess($this->access);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /receiving/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /receiving
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /receiving/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$receiving = $this->receivingRepository->getDetailsById($id);
		$containers = $this->containerRepository->getAllByReceivingId($id);

		//dd($containers->toArray());
		
		return View::make('receiving/show', compact('receiving', 'containers'))->withAccess($this->access);
	}

	public function showCargo($receiving_id, $cargo_id)
	{
		//dd('Show export cargo in detail');
		$cargo = $this->cargoRepository->getExportById($cargo_id);
		$cargoItems = $this->cargoItemRepository->getAllByCargoId($cargo_id);
		$vessel = Vessel::lists('name', 'id');
		// dd($cargo->toArray());

		return View::make('receiving/show_cargo', compact('cargo', 'cargoItems', 'vessel'))->withAccess($this->access);
	}

	public function editCargo($receiving_id, $cargo_id)
	{
		//dd('Edit export cargo details');
		$cargo = $this->cargoRepository->getExportById($cargo_id);
		$portUsers = $this->portUserRepository->getAll()->lists('name', 'id');
		$country = [null=>"Choose a country"] + $this->countryRepository->getAll()->lists('name', 'iso');
		
		//dd($cargo->toArray());

		return View::make('receiving/edit_cargo', compact('cargo', 'portUsers', 'country'))->withAccess($this->access);
	}

	public function updateCargo($receiving_id, $cargo_id)
	{
		$input = Input::all();
		// dd($input);
		$cargo = $this->execute(UpdateExportCargoCommand::class, $input);

		Flash::success("Cargo with B/L No: ".$cargo->bl_no." has been updated!");

		return Redirect::route('receiving.cargo.show', [$receiving_id, $cargo_id]);		
	}

	public function associateContainersWithCargo($receiving_id, $cargo_id)
	{
		$input = Input::all();
		$input['receiving_id'] = $receiving_id;
		$input['cargo_id'] = $cargo_id;
		$input['containers'] = $this->filterContainers($input['containers'], 'L', 2);

		if(!$input['containers']){
			Flash::error("No Containers were registered!");	
			return Redirect::back();
		}

		$messages = $this->execute(AssociateContainersWithCargoCommand::class, $input);

		return Redirect::back();

	}

	public function cargoItemCreate($receiving_id, $cargo_id)
	{

		$input = Input::all();

		$input['receiving_id'] = $receiving_id;
		$input['cargo_id'] = $cargo_id;
		
		// dd($input);

		$this->cargoItemForm->validate($input);

		$this->execute(AddItemToCargoCommand::class, $input);

		Flash::success("Item has been registered!");

		return Redirect::route('receiving.cargo.show', [$receiving_id, $cargo_id]);

	}

	public function cargoItemEdit($receiving_id, $cargo_id, $cargo_item_id)
	{
		$cargo = $this->cargoRepository->getExportById($cargo_id);
		$cargoItem = $this->cargoItemRepository->getById($cargo_item_id);
		//dd($cargoItem->toArray());
		return View::make('receiving/edit_cargo_item', compact('cargo', 'cargoItem'));
	}

	public function cargoItemUpdate($receiving_id, $cargo_id)
	{
		$input = Input::all();

		// dd($input);

		$this->cargoItemForm->validate($input);

		$cargoItem = $this->execute(UpdateCargoItemCommand::class, $input);

		Flash::success("Item successfully updated!");

		return Redirect::route('receiving.cargo.show', [$receiving_id, $cargo_id]);
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

	/**
	 * Update the specified resource in storage.
	 * PUT /receiving/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteContainer($receiving_id)
	{
		$input = Input::all();

		$container = $this->execute(DeleteReceivingContainerCommand::class, $input);

		Flash::success("Container No: ". $container->container_no ." was removed!");

		return Redirect::back();			
	}

	public function unlinkContainer($receiving_id, $cargo_id)
	{
		$input = Input::all();
		$input['cargo_id'] = $cargo_id;

		$container = $this->execute(UnlinkReceivingContainerCommand::class, $input);

		Flash::success("Container No: ". $container->container_no ." was unlinked!");

		return Redirect::back();			
	}
	/**
	 * Remove the specified resource from storage.
	 * DELETE /receiving/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function issueDL($receiving_id, $cargo_id)
	{
		$input = Input::all();
		$input['receiving_id'] = $receiving_id;
		$input['cargo_id'] = $cargo_id;

		//dd($input);
		$this->execute(IssueExportCargoCommand::class, $input);

		Flash::success("DL has been issued!");

		return Redirect::back();
	}

	public function createContainer()
	{
		return View::make('receiving/create_container')->withAccess($this->access);
	}

	public function storeContainer()
	{

		$input = Input::all();

		// filterContainers(containers in string, $content, $status)
		$input['containers'] = $this->filterContainers($input['containers'], 'E', 2);

		if(! $input['containers']) {

			Flash::error("Please key in correctly!");
			return Redirect::back();			
		}

		//dd($input);

		$containers = $this->execute(RegisterReceivingContainersCommand::class, $input);

		Flash::success("Containers successfully registered!");
		
		if(!$containers){
			Flash::error("No Containers were registered!");
			return Redirect::back();
		}

		//dd($containers);
		return Redirect::route('receiving.show', $containers[0]->receiving_id);

	}
	public function createCargo()
	{
		$schedule = [null => "Choose a vessel"] + $this->vesselScheduleRepository->getActiveSchedule()->lists('vessel_voyage', 'id');
		$portUsers = $this->portUserRepository->getAll()->lists('name', 'id');
		return View::make('receiving/create_cargo', compact('portUsers', 'schedule'))->withAccess($this->access);
	}

	public function storeCargo()
	{

		$input = Input::all();
		// dd($input);
		$input['receiving_id'] = $this->receivingRepository->generateReceivingId()->id;

		// filterContainers(containers in string, $content, $status)
		//$input['containers'] = $this->filterContainers($input['containers'], 'L', 2);

		// $this->importCargoForm->validate($input);
		$export_vessel_schedule_id = $input['export_vessel_schedule_id'];
		

		//dd($input);
		$exportCargo = $this->execute(RegisterExportCargoCommand::class, $input);

		Flash::success("Cargo with B/L No: ".$exportCargo->bl_no." has been registered!");

		return Redirect::route('receiving.show', $input['receiving_id']);
	}	
}

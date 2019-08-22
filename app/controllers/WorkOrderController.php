<?php

use Illuminate\Support\Collection;
use LLPM\Forms\WorkOrderForm;
use LLPM\Repositories\CargoRepository;
use LLPM\Repositories\ContainerConfirmationRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\FeeRepository;
use LLPM\Repositories\ImportContainerRepository;
use LLPM\Repositories\PortUserRepository;
use LLPM\Repositories\VesselScheduleRepository;
use LLPM\Repositories\WorkOrderRepository;
use LLPM\WorkOrders\AttachedContainersToWorkOrderCommand;
use LLPM\WorkOrders\CalculateChargesByWorkOrder;
use LLPM\WorkOrders\CalculateStorageChargesByWorkOrder;
use LLPM\WorkOrders\CalculateBondRentByWorkOrder;
use LLPM\WorkOrders\CancelContainerCommand;
use LLPM\WorkOrders\RegisterWorkOrderCommand;
use LLPM\WorkOrders\RegisterWorkOrderTFUSCommand;
use LLPM\WorkOrders\FinalizeWorkOrderCommand;
use LLPM\WorkOrders\UpdateWorkOrderWithAgentCommand;
use Carbon\Carbon;

class WorkOrderController extends \BaseController {

	protected $workOrderRepository;
	protected $containerRepository;
	protected $importContainerRepository;
	protected $vesselScheduleRepository;
	protected $portUserRepository;
	protected $containerConfirmationRepository;
	protected $cargoRepository;
	protected $calculateChargesByWorkOrder;
	protected $feeRepository;
	Protected $workOrderForm;

	protected $movement;
	protected $content;
	protected $calculateStorageChargesByWorkOrder;
	protected $calculateBondRentByWorkOrder;

	protected $bond_days_free = 3;

	function __construct(
		WorkOrderRepository $workOrderRepository,
		ContainerRepository $containerRepository,
		ImportContainerRepository $importContainerRepository,
		VesselScheduleRepository $vesselScheduleRepository,
		PortUserRepository $portUserRepository,
		ContainerConfirmationRepository $containerConfirmationRepository,
		CargoRepository $cargoRepository,
		CalculateChargesByWorkOrder $calculateChargesByWorkOrder,
		FeeRepository $feeRepository,
		WorkOrderForm $workOrderForm,
		CalculateStorageChargesByWorkOrder $calculateStorageChargesByWorkOrder,
		CalculateBondRentByWorkOrder $calculateBondRentByWorkOrder
	)
	{
		parent::__construct();
		$this->workOrderRepository = $workOrderRepository;
		$this->containerRepository = $containerRepository;
		$this->importContainerRepository = $importContainerRepository;
		$this->vesselScheduleRepository = $vesselScheduleRepository;
		$this->portUserRepository = $portUserRepository;
		$this->containerConfirmationRepository = $containerConfirmationRepository;
		$this->cargoRepository = $cargoRepository;
		$this->calculateChargesByWorkOrder = $calculateChargesByWorkOrder;
		$this->feeRepository = $feeRepository;
		$this->workOrderForm = $workOrderForm;
		$this->calculateStorageChargesByWorkOrder = $calculateStorageChargesByWorkOrder;
		$this->calculateBondRentByWorkOrder = $calculateBondRentByWorkOrder;
	}

	/**
	 * Display a listing of the resource.
	 * GET /workorder
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->definition();
		$movement = $this->movement;

		// if(Input::get('view_movement') || Input::get('view_movement') == '') {
		// 	Session::put('workorder.movement', Input::get('view_movement'));
		// } else {
		// 	dd('Not valid!');
		// }

		// dd(Input::get('view_movement'));

		if(Input::get('view_date')) {
			Session::put('workorder.date', Input::get('view_date'));
		}

		if(!Session::get('workorder.date')) {
			Session::put('workorder.date', date('m/Y'));
		}

		if(Input::get('view_movement') || Input::get('view_movement') == '') {
			Session::put('workorder.movement', Input::get('view_movement'));
		}

		if(!Session::get('workorder.movement')) {
			Session::put('workorder.movement', null);
		}

                $checkDate = convertMonthToMySQLDate(Session::get('workorder.date'));

		$workorders = $this->workOrderRepository->getAllByMonth(convertMonthToMySQLDate(Session::get('workorder.date')), Session::get('workorder.movement'));
		return View::make('workorders/index', compact('workorders', 'movement', 'checkDate'))->withAccess($this->access);

	}

	/**
	 * Show the form for creating a new resource.
	 * GET /workorder/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//$handlers = $this->portUserRepository->getAll();
		//dd('Hello');
		$cargoList = $this->cargoRepository->getActiveExportCargoForSelectList();

		return View::make('workorders/create2', compact('cargoList'))->withAccess($this->access);
	}

	public function carrierList()
	{
		$type = Input::get('type');

		//$type = 'HI';

		switch ($type)
		{
			case "HI":
			case "HE":
				$carrierList = $this->vesselScheduleRepository->getActiveSchedule();
				break;
			default:
				$carrierList = $this->portUserRepository->getAll();
		}

		//dd($carrierList->toArray());

		return json_encode($carrierList);

	}

	public function handlerList()
	{
		$q = Input::get('q');
		$handlers= [];

		if ($q) {
			$handlers = $this->portUserRepository->searchByName($q);
		}

		//dd($handlers);

		return json_encode($handlers);

		/* // Sample json data
		[{"id":2701,"text":"MASTER OF TENAGA TIGA"},{"id":41,"text":"MERIDIAN TENAGA S\/B"},{"id":5,"text":"NAGA SHIPPING & TRADING"},{"id":158,"text":"NAGANURI AUTOMOBILE"},{"id":379,"text":"PEMBORONG SERI TENAGA"},{"id":2334,"text":"PENAGA ORBIT S\/B"},{"id":538,"text":"TENAGA M E C(S) S\/B"},{"id":1438,"text":"TENAGA ORBIT S\/B"}]
		*/
	}

	public function containerList()
	{

		$type = Input::get('type');
		$carrier_id = Input::get('carrier_id');
		$containerList= [];

		$movement = explode('-', $type);

		// dd($movement);
		// $type = 'RO';
		// $carrier_id = 502;

		switch ($movement[0])
		{
			case "HI":
				$containerList = $this->containerRepository->getWithScheduleId($carrier_id);
				break;
			case "HE":
				$containerList = $this->containerRepository->getHEForStatus(3,1);
				break;
			case "RI":
				$containerList = $this->containerRepository->getForStatus(2);
				break;
			case "RO":
				$containerList = $this->containerRepository->getROForStatus(3, $movement[1]);
				break;
			case "TF":
				$containerList = $this->containerRepository->getForStatus(3,$movement[1]);
				break;
			case "US":
				if(isset($movement[1])) {
					$containerList = $this->containerRepository->getActiveLadenContainersForUnstuffing($movement[1]);
				} else {
					$containerList = $this->containerRepository->getActiveLadenContainersForUnstuffing(1);
				}
				break;
			case "ST":
				if(isset($movement[1])) {
					$containerList = $this->containerRepository->getActiveEmptyContainersForStuffing($movement[1]);
				} else {
					$containerList = $this->containerRepository->getActiveEmptyContainersForStuffing(1);
				}
				break;
			case "VGM":
				$containerList = $this->containerRepository->getActiveLadenContainersForVGM();
				break;
			case "TFUS":
				$containerList = $this->containerRepository->getActiveLadenContainersForUnstuffing($movement[1]);
				break;
		}

		return json_encode($containerList);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /workorder
	 *
	 * @return Response
	 */
	public function store()
	{

/* 		'type' => string 'HI' (length=2)
		'handler_id' => string '67' (length=2)
		'carrier_id' => string '354' (length=3)
		'containers' =>
			array (size=3)
				0 => string '4' (length=1)
				1 => string '5' (length=1)
				2 => string '7' (length=1) */


		$input = Input::all();

		$this->workOrderForm->validate($input);

		$movement = explode('-', $input['type']);

		// dd($input);


		if($movement[0] == 'ST') {
			foreach($input['containers'] as $key => $value) {
				if($value == '') {
					Flash::error("Cargo not specify correctly");
					return Redirect::back();
				}
			}
		}

		if($movement[0] == 'TFUS') {
			// dd('Create WO TF and US');
			// Register TF-1-3
			$workorder = $this->execute(RegisterWorkOrderTFUSCommand::class, $input);
		} else {
			$workorder = $this->execute(RegisterWorkOrderCommand::class, $input);		
		}
		Flash::success("Work Order $workorder->id successfully registered!");
		return Redirect::route('workorders');
	}

	/**
	 * Display the specified resource.
	 * GET /workorder/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		$workOrder = $this->workOrderRepository->getDetailsById($id);

		// if($workOrder->movement == 'HI' || $workOrder->movement == 'HE') {
		// 	$carrier =
		// }

		//dd($workOrder);
		//$containersConfirmation = $this->containerConfirmationRepository->getByWorkOrderId($id);

		//dd($workOrder->containers->toArray());

		//dd($containersConfirmation->first()->container->container_no);
		return View::make('workorders/show', compact('workOrder'))->withAccess($this->access);
	}

	public function generate_workorder($id)
	{

		$workOrder = $this->workOrderRepository->getDetailsById($id);
		$handler = $this->portUserRepository->getById($workOrder->handler_id);

		if($workOrder->movement == 'HI') {
			$carrierObj = $this->vesselScheduleRepository->getById($workOrder->vessel_schedule_id);
			$carrier = $carrierObj->vessel->name . ' v.' . $carrierObj->voyage_no_arrival;

		} elseif($workOrder->movement == 'HE') {
			$carrierObj = $this->vesselScheduleRepository->getById($workOrder->vessel_schedule_id);
			$carrier = $carrierObj->vessel->name . ' v.' . $carrierObj->voyage_no_departure;

		} else {
			$carrier = $this->portUserRepository->getById($workOrder->carrier_id)->name;
		}

		//dd($workOrder);
		//$containersConfirmation = $this->containerConfirmationRepository->getByWorkOrderId($id);

		//dd($workOrder->containers->toArray());

		//dd($containersConfirmation->first()->container->container_no);
		$this->definition();
		$movement = $this->movement;
		$content = $this->content;

		return View::make('workorders/generate_workorder', compact('workOrder', 'handler', 'carrier', 'movement', 'content'))->withAccess($this->access);
	}

	public function generate_handling($workorder_id)
	{

		$workOrder = $this->workOrderRepository->getDetailsById($workorder_id);
		$handler = $this->portUserRepository->getById($workOrder->handler_id);
		$fees = json_decode($this->feeRepository->getHandlingFeeByDate($workOrder->movement, $workOrder->date), true);
		$containerList = new Collection;
		$total_charges = 0;

		// dd($fees);

		if($workOrder->movement == 'HI') {
			$carrierObj = $this->vesselScheduleRepository->getById($workOrder->vessel_schedule_id);
			$carrier = $carrierObj->vessel->name . ' v.' . $carrierObj->voyage_no_arrival;

		} elseif($workOrder->movement == 'HE') {
			$carrierObj = $this->vesselScheduleRepository->getById($workOrder->vessel_schedule_id);
			$carrier = $carrierObj->vessel->name . ' v.' . $carrierObj->voyage_no_departure;

		} else {
			$carrier = $this->portUserRepository->getById($workOrder->carrier_id)->name;
		}

		foreach($workOrder->containers as $container) {
			$feeSize = $container->size;
			$feeSizeContent = $container->size . $container->pivot->content;
			// $getFeeType = $container->size . $container->content;

			if(isset($fees[$feeSize])) {
				$fee = $fees[$feeSize];
			} else {
				$fee = $fees[$feeSizeContent];
			}
			$total_charges += $fee;

			$newContainer = $container->toArray();
			$newContainer['handling'] = $fee;

			$containerList->push($newContainer);
		}

		// dd($containerList);
		//dd($workOrder);
		//$containersConfirmation = $this->containerConfirmationRepository->getByWorkOrderId($id);

		//dd($workOrder->containers->toArray());

		$this->definition();
		$movement = $this->movement;
		$content = $this->content;
		//dd($containersConfirmation->first()->container->container_no);
		return View::make('workorders/generate_handling', compact('containerList', 'workOrder', 'handler', 'carrier', 'movement', 'content', 'total_charges'))->withAccess($this->access);
	}

	public function generate_storage($workorder_id)
	{
		$workOrder = $this->workOrderRepository->getDetailsById($workorder_id);
		$handler = $this->portUserRepository->getById($workOrder->handler_id);
		$agent = $this->portUserRepository->getById($workOrder->agent_id);
		$fees = json_decode($this->feeRepository->getStorageFeeByDate($workOrder->date), true);
		$containerList = new Collection;
		$total_charges = 0;

		// dd($fees);

		foreach($workOrder->containers as $container) {

			$containerInfo = $this->getContainerInfo($container, $fees);
			$total_charges += $containerInfo['charges'];
			$containerList->push($containerInfo);

		}

		$this->definition();
		$movement = $this->movement;
		$content = $this->content;

		// dd($total_charges);
		return View::make('workorders/generate_storage', compact('containerList', 'workOrder', 'agent', 'movement', 'content', 'total_charges'))->withAccess($this->access);
	}

	public function generate_bond($workorder_id)
	{
		// dd('Hello');
		$workOrder = $this->workOrderRepository->getDetailsById($workorder_id);
		$handler = $this->portUserRepository->getById($workOrder->handler_id);
		$containerList = new Collection;
		$total_charges = 0;

		// dd($fees);

		foreach($workOrder->containers as $container) {

			$containerInfo = $this->getBondContainerInfo($container, $workOrder);
			$total_charges += $containerInfo['bond_rent'];
			$containerList->push($containerInfo);

		}

		$this->definition();
		$movement = $this->movement;
		$content = $this->content;

		// dd($containerInfo);

		// dd($total_charges);
		return View::make('workorders/generate_bond', compact('containerList', 'workOrder', 'movement', 'content', 'total_charges'))->withAccess($this->access);
	}

	public function getBondContainerInfo($container, $workorder)
	{
		$movement = $workorder->movement;
		$content = $container->pivot->content;

		$info['date_start'] = '';
		$info['date_end'] = '';

		$info['container_no'] = $container->container_no;
		$info['size'] = $container->size . $content;
		$info['days_bond'] = $container->days_bond_import;

		if($movement == 'HE') {
			$info['days_bond'] = $container->days_bond_export;
		}

		if($content == 'L') {
			$info['date_start'] = $this->getBondStartDate($container, $workorder);
			$info['date_end'] = $this->getBondEndDate($container, $workorder);
		}

		$info['num_weeks'] = $this->getNumWeeks($info['days_bond']);
		$info['bond_fee'] = $this->getBondFee($info['num_weeks']);
		$info['m3'] = $this->getM3($info['size']);
		$info['bond_rent'] = $info['num_weeks'] * $info['bond_fee'] * $info['m3'];

		if($info['days_bond'] <= $this->bond_days_free) {
			$info['bond_rent'] = 0;
		}

		return $info;
	}

	public function getNumWeeks($days_bond)
	{
		$floor = floor($days_bond/7);
		if($days_bond % 7 == 0){
			return $floor;
		}

		return $floor + 1;
	}

	public function getBondStartDate($container, $workorder)
	{
		// This function need to think through
		// It's only cater for Laden containers.
		// If it's empty containers, it will not display property.


		if($workorder->movement == 'HE') {
			foreach($container->workorders as $wo) {
				if($wo->movement == 'ST' || $wo->movement == 'ST-1' || $wo->movement == 'ST-3' || $wo->movement == 'RI-1' ) {
					return $wo->pivot->confirmed_at;
				}
			}
		}

		foreach($container->workorders as $wo) {
			if($wo->movement == 'HI' ) {
				// dd($wo->vesselSchedule->eta);
				return $wo->vesselSchedule->eta;
			}
		}
	}

	public function getBondEndDate($container, $workorder)
	{
		// dd($container->toArray());
		if($workorder->movement == 'HE') {

			foreach($container->workorders as $wo) {
				if($wo->movement == 'HE') {
					return $wo->pivot->confirmed_at;
				}
			}
			// return $workorder->pivot->confirmed_at;
		}

		foreach($container->workorders as $wo) {
			if($wo->movement == 'US' || $wo->movement == 'US-1' || $wo->movement == 'US-3' || $wo->movement == 'RO-1') {
				return $wo->pivot->confirmed_at;
			}
		}
	}

	public function getContainerInfo($container, $fees)
	{
		$info['container_no'] = $container->container_no;
		$info['size'] = $container->size;
		$info['days_empty'] = $container->days_empty;

		if($container->days_empty - 5 < 0) {
			$days_charged = 0;
		} else {
			$days_charged = $container->days_empty - 5;
		}

		$info['days_charged'] = $days_charged;
		$info['charges'] = $days_charged * $fees[$container->size];

		$info['us_workorder'] = '';
		$info['us_date'] = '';
		$info['us_content'] = '';

		$info['st_workorder'] = '';
		$info['st_date'] = '';
		$info['st_content'] = '';
		// dd($container->workorders->toArray());

		foreach($container->workorders as $workorder) {

			$movement = explode('-', $workorder->movement);

			$confirmed_at = Carbon::createFromFormat('Y-m-d H:i:s', $workorder->pivot->confirmed_at);

			// dd($confirmed_at);
			// var_dump($movement);

			if($movement[0] == 'HI' || $movement[0] == 'RI') {
				$info['in_workorder'] = $workorder->id;
				$info['in_date'] = $confirmed_at;
				$info['in_content'] = $workorder->pivot->content;
			}

			if($movement[0] == 'US') {
				$info['us_workorder'] = $workorder->id;
				$info['us_date'] = $confirmed_at;
				$info['us_content'] = $workorder->pivot->content;
			}

			if($movement[0] == 'ST') {
				$info['st_workorder'] = $workorder->id;
				$info['st_date'] = $confirmed_at;
				$info['st_content'] = $workorder->pivot->content;
			}

			if($movement[0] == 'HE' || $movement[0] == 'RO') {
				$info['out_workorder'] = $workorder->id;
				$info['out_date'] = $confirmed_at;
				$info['out_content'] = $workorder->pivot->content;
			}
		}

		return $info;
	}

	public function definition()
	{
		$movement['HI'] = 'Haulage Import';
		$movement['HE'] = 'Haulage Export';
		$movement['RI-1'] = 'Remove In (CY1)';
		$movement['RI-3'] = 'Remove In (CY3)';
		$movement['RO-1'] = 'Remove Out (CY1)';
		$movement['RO-3'] = 'Remove Out (CY3)';
		$movement['TF-3-1'] = 'Transfer to CY1';
		$movement['TF-1-3'] = 'Transfer to CY3';
		$movement['US'] = 'Unstuffing';
		$movement['US-1'] = 'Unstuffing (CY1)';
		$movement['US-3'] = 'Unstuffing (CY3)';
		$movement['ST'] = 'Stuffing';
		$movement['ST-1'] = 'Stuffing (CY1)';
		$movement['ST-3'] = 'Stuffing (CY3)';
		$movement['EM'] = 'Extra Movement';
		$movement['VGM'] = 'VGM';

		$content['E'] = 'Empty';
		$content['L'] = 'Laden';

		$this->movement = $movement;
		$this->content = $content;
	}

	public function getBondFee($week)
	{
		$bond = [
			0 => 0,
			1 => 3,
			2 => 6,
			3 => 12,
			4 => 24,
			5 => 48,
			6 => 48,
			7 => 48,
			8 => 48,
			9 => 96,
			10 => 96,
			11 => 96,
			12 => 96,
			13 => 192,
			14 => 192,
			15 => 192,
			16 => 192,
			17 => 384
		];

		return $bond[$week];
	}

	public function getM3($container_size)
	{
		if($container_size == 20) {
			return 25;
		}

		return 50;
	}
	/**
	 * Show the form for editing the specified resource.
	 * GET /workorder/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /workorder/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /workorder/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function cancelContainer($id)
	{

		$input = Input::all();
		$input['workorder_id'] = $id;

		if(! $input['container_id']) {

			Flash::error("There was an error!");
			return Redirect::back();
		}

		$container = $this->execute(CancelContainerCommand::class, $input);

		Flash::success("Container # $container->container_no has been cancelled!");

		return Redirect::route('workorders.show', $id);
	}

	public function createUnstuffing()
	{
		// get list of laden containers
		$containers = $this->containerRepository->getActiveLadenContainers();
		$handlers = $this->portUserRepository->getAll();
		//$handlers = $this->portUserRepository->getAll();
		// dd($containers->toArray());
		return View::make('workorders/create_unstuffing', compact('containers', 'handlers'))->withAccess($this->access);
	}

	public function storeUnstuffing()
	{
		//dd(Input::all());


		$input = Input::all();
		$input['type'] = "US";
		$input['location'] = 1;

		if(! $input['containers']) {

			Flash::error("Please key in correctly!");
			return Redirect::back();
		}

		$workorder = $this->execute(RegisterWorkOrderCommand::class, $input);

		Flash::success("Work Order $workorder->id successfully registered!");

		return Redirect::route('workorders');
	}

	public function createStuffing()
	{
		$containers = $this->containerRepository->getActiveEmptyContainers();
		$handlers = $this->portUserRepository->getAll();
		$cargoList = $this->cargoRepository->getActiveExportCargoForSelectList();
		//dd($containers->toArray());
		return View::make('workorders/create_stuffing', compact('containers', 'handlers', 'cargoList'))->withAccess($this->access);
	}

	public function storeStuffing()
	{
		//dd(Input::all());
		$input = Input::all();
		$input['type'] = "ST";
		$input['location'] = 1;

		if(! $input['containers']) {

			Flash::error("Please key in correctly!");
			return Redirect::back();
		}

		$workorder = $this->execute(RegisterWorkOrderCommand::class, $input);

		Flash::success("Work Order $workorder->id successfully registered!");

		return Redirect::route('workorders');
	}

	public function addContainers($workorder_id)
	{
		$input = Input::all();
		$input['workorder_id'] = $workorder_id;

		// dd($input);

		if(! $input['containers']) {

			Flash::error("Please key in correctly!");
			return Redirect::back();
		}

		$workorder = $this->execute(AttachedContainersToWorkOrderCommand::class, $input);

		Flash::success("Work Order $workorder->id successfully updated!");

		return Redirect::route('workorders.show', $workorder_id);
	}

	public function recalculate($workorder_id)
	{
		// dd($workorder_id);
		$workorder = $this->workOrderRepository->getById($workorder_id);
		$this->calculateChargesByWorkOrder->fire($workorder);

		return Redirect::route('workorders.show', $workorder_id);

	}

	public function recalculateStorage($workorder_id)
	{
		// dd($workorder_id);
		$workorder = $this->workOrderRepository->getById($workorder_id);
		$this->calculateStorageChargesByWorkOrder->fire($workorder);

		return Redirect::route('workorders.show', $workorder_id);

	}

	public function recalculateBond($workorder_id)
	{
		// dd($workorder_id);
		$workorder = $this->workOrderRepository->getById($workorder_id);
		$this->calculateBondRentByWorkOrder->fire($workorder);

		return Redirect::route('workorders.show', $workorder_id);

	}

	public function finalize($workorder_id)
	{
		$input['workorder_id'] = $workorder_id;
		// dd($input);

		$workorder = $this->execute(FinalizeWorkOrderCommand::class, $input);

		if(! $workorder) {

			Flash::error("Unable to finalize at this moment. Please make sure all containers are confirmed.");
			return Redirect::back();
		}

		// Calculate Storage Charges
		$this->calculateStorageChargesByWorkOrder->fire($workorder);

		// Calculate Bond Rent
		$this->calculateBondRentByWorkOrder->fire($workorder);

		Flash::success("Work Order $workorder->id successfully finalized!");

		return Redirect::route('workorders.show', $workorder_id);
	}

	public function storeAgent($workorder_id)
	{
		$input = Input::all();
		$input['workorder_id'] = $workorder_id;

		if(! $input['agent_id']) {

			Flash::error("No agent was selected.");
			return Redirect::back();
		}

		$workorder = $this->execute(UpdateWorkOrderWithAgentCommand::class, $input);

		Flash::success("Agent id, ". $input['agent_id'].", was selected for Workorder $workorder->id");

		return Redirect::route('workorders.show', $workorder_id);
		// dd($input);
	}
}

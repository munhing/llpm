<?php

use Carbon\Carbon;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\ContainerWorkorderConfirmationRepository;
use LLPM\Repositories\FeeRepository;
use LLPM\Repositories\VesselScheduleRepository;

class ContainerController extends \BaseController {

	protected $containerRepository;
	protected $containerWorkorderConfirmationRepository;
	protected $feeRepository;
	protected $vesselScheduleRepository;
	protected $totalStorageCharges = 0;

	function __construct(
		ContainerRepository $containerRepository,
		ContainerWorkorderConfirmationRepository $containerWorkorderConfirmationRepository,
		FeeRepository $feeRepository,
		VesselScheduleRepository $vesselScheduleRepository
	)
	{
		parent::__construct();
		$this->containerRepository = $containerRepository;
		$this->containerWorkorderConfirmationRepository = $containerWorkorderConfirmationRepository;
		$this->feeRepository = $feeRepository;
		$this->vesselScheduleRepository = $vesselScheduleRepository;
	}	
	/**
	 * Display a listing of the resource.
	 * GET /container
	 *
	 * @return Response
	 */
	public function index()
	{
		//dd('List containers in the port');
		$containers = $this->addStorageCharges($this->containerRepository->getAllActive());
		$totalStorageCharges = $this->totalStorageCharges;

		// dd($containers->first()->workorders->first()->pivot->updated_at);
		// dd($containers->first()->toArray());

		// dd($containers[50]->workorders->first()->pivot->updated_at->format('Y-m-d'));
		return View::make('containers/index', compact('containers', 'totalStorageCharges'))->withAccess($this->access);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /container/create
	 *
	 * @return Response
	 */
	public function addStorageCharges($containers)
	{
		$ctn = [];

		$fees = json_decode($this->feeRepository->getStorageFee(), true);

		foreach($containers as $container){

			$storage_charges = 0;

			if($container->days_empty > 5) {
				$storage_charges = ($container->days_empty - 5) * $fees[$container->size];
			}

			$container->storage_charges = $storage_charges;
			$this->totalStorageCharges += $storage_charges;

			$ctn[] = $container;
		}

		return $ctn;
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /container
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /container/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($container_id)
	{
		$container = $this->containerRepository->getById($container_id);

		//dd($container->toArray());

		return View::make('containers/show', compact('container'))->withAccess($this->access);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /container/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function report()
	{
		$ctnlist = [];
		$processedList = [];

		$ctncons = $this->containerWorkorderConfirmationRepository->getAll();


		foreach($ctncons as $ctncon) {
			$ctnlist[$ctncon->container_no . '-' . $ctncon->container_workorder_id][] = $ctncon;
		}

		foreach($ctnlist as $key => $list) {
			$i=1;
			foreach($list as $cwc) {
				// dd($cwc->toArray());
				if($i==1) {

					$processedList[$key]['vessel'] = $this->getVessel($cwc);

					$processedList[$key]['date'] = $cwc->confirmed_at->format('Y-m-d');
					$processedList[$key]['container_no'] = $cwc->container->container_no;
					$processedList[$key]['size'] = $cwc->container->size;
					$processedList[$key]['content'] = $cwc->containerConfirmation->content;
					$processedList[$key]['workorder_id'] = $cwc->workorder->id;
					$processedList[$key]['movement'] = $cwc->workorder->movement;
					$processedList[$key]['vehicle'] = $cwc->containerConfirmation->vehicle;
					$processedList[$key]['lifter'] = $cwc->containerConfirmation->lifter;
					$processedList[$key]['confirmed_at'] = $cwc->confirmed_at->format('H:i') . " (" . $cwc->role . ")";
					$processedList[$key]['operator'] = $cwc->operator->name;
					$processedList[$key]['confirmed_by'] = $cwc->user->name;
				}

				if($i>1) {				
					$processedList[$key]['confirmed_at'] .= " - " . $cwc->confirmed_at->format('H:i') . " (" . $cwc->role . ")" ;
					$processedList[$key]['operator'] .= " / " . $cwc->operator->name;
					$processedList[$key]['confirmed_by'] .= " / " . $cwc->user->name;
				}

				// if($i == count($list)) {
				// 	$processedList[$key]['duration'] = $cwc->user->username;	
				// }

				$i++;
			}
		}

		// dd($processedList);
		return View::make('containers/report', compact('processedList'));
	}


	public function getVessel($cwc)
	{
		$movement = $cwc->workorder->movement;

		if($movement == 'HI' || $movement == 'HE') {
			// dd($cwc->workorder->movement);
			$schedule = $this->vesselScheduleRepository->getById($cwc->workorder->vessel_schedule_id);

			if($movement == 'HI') {
				return $schedule->vessel->name . " V" . $schedule->voyage_no_arrival;
			}			

			if($movement == 'HE') {
				return $schedule->vessel->name . " V" . $schedule->voyage_no_departure;
			}
			// dd($schedule);
		}

		return;

	}

	/**
	 * Update the specified resource in storage.
	 * PUT /container/{id}
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
	 * DELETE /container/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
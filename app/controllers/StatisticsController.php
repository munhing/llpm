<?php

use LLPM\Repositories\ContainerConfirmationRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\UserRepository;
use LLPM\Repositories\VesselScheduleRepository;
use LLPM\Repositories\WorkOrderRepository;

class StatisticsController extends \BaseController {

	protected $containerRepository;
	protected $workOrderRepository;
	protected $containerConfirmationRepository;
	protected $vesselScheduleRepository;
	protected $userRepository;

	function __construct(
		ContainerRepository $containerRepository,
		WorkOrderRepository $workOrderRepository,
		ContainerConfirmationRepository $containerConfirmationRepository,
		VesselScheduleRepository $vesselScheduleRepository,
		UserRepository $userRepository
	)
	{
		parent::__construct();
		$this->containerRepository = $containerRepository;
		$this->workOrderRepository = $workOrderRepository;
		$this->containerConfirmationRepository = $containerConfirmationRepository;
		$this->vesselScheduleRepository = $vesselScheduleRepository;
		$this->userRepository = $userRepository;
	}

	/**
	 * Display a listing of the resource.
	 * GET /statistics
	 *
	 * @return Response
	 */
	public function dashboard()
	{
		$data = [];
		$data['containers'] = $containers = $this->containerRepository->getAllActive()->count();
		$data['workorders'] = $workorders = $this->workOrderRepository->getAllToday()->count();
		$data['pending_containers'] = $pendingContainers = $this->containerConfirmationRepository->getAllPending()->count();
		$data['pending_portusers'] = $pendingPortusers = $this->userRepository->getPendingPortUsers()->count();
		$data['vessel_schedule'] = $vessel_schedule = $this->vesselScheduleRepository->getActiveSchedule(); 
		return json_encode($data);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /statistics/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /statistics
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /statistics/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /statistics/{id}/edit
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
	 * PUT /statistics/{id}
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
	 * DELETE /statistics/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
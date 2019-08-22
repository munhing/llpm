<?php

use LLPM\Repositories\WorkOrderRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\CargoRepository;
use LLPM\Repositories\VesselScheduleRepository;

class SearchController extends \BaseController {

	protected $workOrderRepository;
	protected $containerRepository;
	protected $cargoRepository;
	protected $vesselScheduleRepository;

	function __construct(
		WorkOrderRepository $workOrderRepository,
		ContainerRepository $containerRepository,
		CargoRepository $cargoRepository,
		VesselScheduleRepository $vesselScheduleRepository
	)
	{
		parent::__construct();
		$this->workOrderRepository = $workOrderRepository;
		$this->containerRepository = $containerRepository;
		$this->cargoRepository = $cargoRepository;
		$this->vesselScheduleRepository = $vesselScheduleRepository;
	}

	public function index()
	{
		return View::make('search/index')->withAccess($this->access);
	}

	public function workorder()
	{
		$query = Input::get('query');
		$page = Input::get('page', 1);
		return $this->workOrderRepository->search($query,$page)->toJson();
	}

	public function container()
	{
		$query = Input::get('query');
		$page = Input::get('page', 1);
		return $this->containerRepository->search($query,$page)->toJson();
	}

	public function cargo()
	{
		$query = Input::get('query');
		$page = Input::get('page', 1);
		return $this->cargoRepository->search($query,$page)->toJson();
	}

	public function manifest()
	{
		$query = Input::get('query');
		$page = Input::get('page', 1);
		return $this->vesselScheduleRepository->search($query,$page)->toJson();
	}	
}
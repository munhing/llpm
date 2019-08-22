<?php

use LLPM\Repositories\WorkOrderRepository;

class VueController extends \BaseController {

	protected $workOrderRepository;


	function __construct(
		WorkOrderRepository $workOrderRepository
	)
	{
		$this->workOrderRepository = $workOrderRepository;
	}

	public function index()
	{
		return View::make('vue/index');
	}

	public function api()
	{
		$q = Input::get('q');
		return $this->workOrderRepository->api($q)->toArray();
	}

}

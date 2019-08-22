<?php

use Carbon\Carbon;
use LLPM\Containers\ContainerTracking;
use LLPM\Containers\ContainerTrackingStatus;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\ContainerWorkorderConfirmationRepository;
use LLPM\Repositories\FeeRepository;
use LLPM\Repositories\VesselScheduleRepository;

class TrackingController extends \BaseController {

	protected $containerRepository;
	protected $containerWorkorderConfirmationRepository;
	protected $feeRepository;
	protected $vesselScheduleRepository;
	protected $containerTracking;
	protected $containerTrackingStatus;
	protected $totalStorageCharges = 0;

	function __construct(
		ContainerRepository $containerRepository,
		ContainerWorkorderConfirmationRepository $containerWorkorderConfirmationRepository,
		FeeRepository $feeRepository,
		VesselScheduleRepository $vesselScheduleRepository,
		ContainerTracking $containerTracking,
		ContainerTrackingStatus $containerTrackingStatus
	)
	{
		parent::__construct();
		$this->containerRepository = $containerRepository;
		$this->containerWorkorderConfirmationRepository = $containerWorkorderConfirmationRepository;
		$this->feeRepository = $feeRepository;
		$this->vesselScheduleRepository = $vesselScheduleRepository;
		$this->containerTracking = $containerTracking;
		$this->containerTrackingStatus = $containerTrackingStatus;
	}

	/**
	 * Display a listing of the resource.
	 * GET /tracking
	 *
	 * @return Response
	 */
	public function index()
	{


		$info = '';
		$textfield = '';

		
		///////////////////////////////////////////////////////////////////////////////////////
		for ($x=0;$x<15;$x++) {
			$textfield .= "<tr><td><input type=text name=textbox[$x] class=field></td></tr>";
		}
		
		$textfields = "
			<table>
				$textfield
			</table>
		";

		$url = route('tracking.container.track');

		// dd($url);

		return View::make('tracking/index', compact('info', 'textfields', 'url'))->withAccess($this->access);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /tracking/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /tracking
	 *
	 * @return Response
	 */
	public function track()
	{
		$input = Input::all();

		if($input['action'] == 'status') {
			$info = $this->containerTrackingStatus->fire($input['containers']);
		}

		if($input['action'] == 'history') {
			$info = $this->containerTracking->fire($input['containers']);
		}

		// dd($info);
		// get duplicate counts
		
		$infoCount = $this->valueCount($info);
		// dd($infoCount['CRSU1247809']);
		// 
		
		// $cookie = Cookie::forever('inputed_containers', $input['tag']);

		// // dd(Cookie::get('containers'));
		// return Redirect::route('tracking.container')->withCookie($cookie);
		if($input['action'] == 'status') {		
			return View::make('tracking/status', compact('info', 'infoCount'))->withAccess($this->access);
		}
		if($input['action'] == 'history') {
			return View::make('tracking/tracking', compact('info', 'infoCount'))->withAccess($this->access);
		}
	}


	public function valueCount($info)
	{
		$infoCount = [];

		foreach($info['containers'] as $container) {
			if(!isset($infoCount[$container['container_no']])) {
				$infoCount[$container['container_no']] = 1;
			} else {
				$infoCount[$container['container_no']] += 1;
			}
		}

		return $infoCount;
	}
	/**
	 * Display the specified resource.
	 * GET /tracking/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function detail($container_id)
	{
		$container = $this->containerRepository->getById($container_id);

		// dd($container->toArray());

		return View::make('tracking/details', compact('container'))->withAccess($this->access);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /tracking/{id}/edit
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
	 * PUT /tracking/{id}
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
	 * DELETE /tracking/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
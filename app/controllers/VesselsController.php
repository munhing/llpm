<?php

use LLPM\Repositories\VesselRepository;
use LLPM\Forms\VesselForm;
use LLPM\Vessels\RegisterVesselCommand;


class VesselsController extends \BaseController {

	protected $vesselRepository;
	protected $vesselForm;

	function __construct(VesselRepository $vesselRepository, VesselForm $vesselForm)
	{
		parent::__construct();
		$this->vesselRepository = $vesselRepository;
		$this->vesselForm = $vesselForm;

	}

	/**
	 * Display a listing of the resource.
	 * GET /vessels
	 *
	 * @return Response
	 */
	public function index()
	{
		$vessels = $this->vesselRepository->getAll();
		return View::make('vessels/index', compact('vessels'))->withAccess($this->access);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /vessels/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('vessels/create')->withAccess($this->access);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /vessels
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->vesselForm->validate(Input::all());

		$vessel = $this->execute(RegisterVesselCommand::class);

		Flash::success("Vessel $vessel->name has been registered!");

		return Redirect::route('manifest.vessels');
	}


	public function vesselList()
	{
		$q = Input::get('q');
		$vessels= [];

		if ($q) {
			$vessels = $this->vesselRepository->searchByName($q);	
		}

		//dd($handlers);

		return json_encode($vessels);		
	}
	
	/**
	 * Display the specified resource.
	 * GET /vessels/{id}
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
	 * GET /vessels/{id}/edit
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
	 * PUT /vessels/{id}
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
	 * DELETE /vessels/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
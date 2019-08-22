<?php

use LLPM\Repositories\CargoRepository;

class CargoController extends \BaseController {

	protected $cargoRepository;

	function __construct(CargoRepository $cargoRepository)
	{
		parent::__construct();
		$this->cargoRepository = $cargoRepository;
	}

	/**
	 * Display a listing of the resource.
	 * GET /cargo
	 *
	 * @return Response
	 */
	public function index()
	{
		$cargoes = $this->cargoRepository->getAllWithStatus2And3();

		return View::make('cargo/index', compact('cargoes'))->withAccess($this->access);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /cargo/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /cargo
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /cargo/{id}
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
	 * GET /cargo/{id}/edit
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
	 * PUT /cargo/{id}
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
	 * DELETE /cargo/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
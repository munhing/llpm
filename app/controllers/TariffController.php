<?php

use LLPM\Repositories\CustomTariffRepository;

class TariffController extends \BaseController {

	protected $customTariffRepository;

	public function __construct(CustomTariffRepository $customTariffRepository)
	{
		parent::__construct();
		$this->customTariffRepository = $customTariffRepository;
	}


	/**
	 * Display a listing of the resource.
	 * GET /tariff
	 *
	 * @return Response
	 */
	public function index()
	{
		// dd("Tariff Page");
		// var_dump($this->customTariffRepository->getByCode('390940900')->toArray());
		
		$tariff = $this->customTariffRepository->getAll();
		// foreach($tariff as $code) {
		// 	var_dump('Code:'.$code->code. ' UOQ:' . $code->uoq . ' Description:' . $code->description);
		// }

		return View::make('tariff/index', compact('tariff'))->withAccess($this->access);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /tariff/create
	 *
	 * @return Response
	 */
	public function find()
	{
		$code = Input::get('tariff_code');

		$tariff = $this->customTariffRepository->getByCode($code);

		return $tariff;
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /tariff
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /tariff/{id}
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
	 * GET /tariff/{id}/edit
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
	 * PUT /tariff/{id}
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
	 * DELETE /tariff/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
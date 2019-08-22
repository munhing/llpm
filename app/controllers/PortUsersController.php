<?php

use LLPM\Forms\PortUserForm;
use LLPM\Repositories\PortUserRepository;
use LLPM\PortUser\RegisterPortUserCommand;


class PortUsersController extends \BaseController {

	protected $portUserRepository;
	protected $portUserForm;

	function __construct(PortUserRepository $portUserRepository, PortUserForm $portUserForm)
	{
		parent::__construct();
		$this->portUserRepository = $portUserRepository;
		$this->portUserForm = $portUserForm;
	}

	/**
	 * Display a listing of the resource.
	 * GET /portusers
	 *
	 * @return Response
	 */
	public function index()
	{
		$portUsers = $this->portUserRepository->getAll();
		return View::make('portusers/index', compact('portUsers'))->withAccess($this->access);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /portusers/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('portusers/create')->withAccess($this->access);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /portusers
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->portUserForm->validate(Input::all());

		$portUser = $this->execute(RegisterPortUserCommand::class);

		Flash::success("Port User ".$portUser->name." has been registered!");

		return Redirect::route('portusers');
	}

	/**
	 * Display the specified resource.
	 * GET /portusers/{id}
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
	 * GET /portusers/{id}/edit
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
	 * PUT /portusers/{id}
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
	 * DELETE /portusers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
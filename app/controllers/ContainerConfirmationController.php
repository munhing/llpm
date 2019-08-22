<?php

use LLPM\Forms\ContainerConfirmationForm;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\ContainerConfirmationRepository;
use LLPM\Repositories\ContainerConfirmationProcessRepository;

use LLPM\Confirmation\ConfirmContainerCommand;

class ContainerConfirmationController extends \BaseController {

	protected $containerRepository;
	protected $containerConfirmationRepository;
	protected $containerConfirmationProcessRepository;
	protected $containerConfirmationForm;

	function __construct(
		ContainerRepository $containerRepository, 
		ContainerConfirmationRepository $containerConfirmationRepository,
		ContainerConfirmationProcessRepository $containerConfirmationProcessRepository,
		ContainerConfirmationForm $containerConfirmationForm
	)
	{
		parent::__construct();
		$this->containerRepository = $containerRepository;
		$this->containerConfirmationRepository = $containerConfirmationRepository;
		$this->containerConfirmationProcessRepository = $containerConfirmationProcessRepository;
		$this->containerConfirmationForm = $containerConfirmationForm;
	}

	/**
	 * Display a listing of the resource.
	 * GET /workorder
	 *
	 * @return Response
	 */
	public function index()
	{
		$check_points = [];
		$containers = $this->containerRepository->getContainersToConfirm();

		// dd($containers->toArray());
		$cp = $this->containerConfirmationProcessRepository->getAllProcesses();

		foreach ($cp as $key => $value) {
			$check_points[$value->movement] = $value;
		}
		// foreach($containers as $container) {
		// 	var_dump($container->workorders->last()->toArray());
		// }

		// die();
		// foreach($containers as $ctn) {

		// 	var_dump($ctn->workorders->last()->pivot->vehicle);
		// }

		return View::make('container_confirmation/index', compact('containers', 'check_points'))->withAccess($this->access);

	}

	/**
	 * Show the form for creating a new resource.
	 * GET /workorder/create
	 *
	 * @return Response
	 */
	public function create()
	{

	}

	/**
	 * Store a newly created resource in storage.
	 * POST /workorder
	 *
	 * @return Response
	 */
	public function store()
	{
		
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
	public function update()
	{
		// dd(Input::all());
		$input = Input::all();
		// dd($input);

		$this->containerConfirmationForm->validate($input);

		if(! isset($input['bypass'])) {
			$input['bypass'] = false;
		}


        function jsonify($value)
        {
            return json_encode([$value]);
        }

        $jsonInput = array_map("jsonify", $input);

		// dd($jsonInput);    

		$this->execute(ConfirmContainerCommand::class, $jsonInput);

		//dd($confirmation);

		Flash::success('Confirmation successful!');

		return Redirect::route('confirmation');		
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

}
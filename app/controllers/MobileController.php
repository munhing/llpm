<?php

use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\ContainerConfirmationProcessRepository;
use LLPM\Confirmation\ConfirmContainerCommand;

class MobileController extends \BaseController {

	protected $containerRepository;
	protected $containerConfirmationProcessRepository;

	function __construct(ContainerRepository $containerRepository, ContainerConfirmationProcessRepository $containerConfirmationProcessRepository)
	{
		$this->containerRepository = $containerRepository;
		$this->containerConfirmationProcessRepository = $containerConfirmationProcessRepository;
	}	

	/**
	 * Display a listing of the resource.
	 * GET /mobile
	 *
	 * @return Response
	 */
	public function index()
	{
		//dd('This is the mobile site');
		$role = Auth::user()->roles->first()->role;
		$pusher_var = Config::get('services.pusher');
		$pusher_var['event'] = $role;
		$containers = $this->containerRepository->getContainersToConfirmByRole($role);
		// dd(Auth::user()->roles->first()->role);
		// dd($containers->toArray());
		// if(Auth::user()->id == 1) {
		// 	$pusher_var['event'] = 'FO';
		// } else {
		// 	$pusher_var['event'] = 'MG';
		// }

		return View::make('mobile/index', compact('containers', 'pusher_var'));
	}

	public function overview()
	{
		//dd('This is the mobile site');
		$check_points = [];
		$role = Auth::user()->roles->first()->role;
		$pusher_var = Config::get('services.pusher');
		$pusher_var['event'] = $role;
		$containers = $this->containerRepository->getContainersToConfirm();
		$cp = $this->containerConfirmationProcessRepository->getAllProcesses();
		// dd(Auth::user()->roles->first()->role);
		// dd($containers->toArray());
		// if(Auth::user()->id == 1) {
		// 	$pusher_var['event'] = 'FO';
		// } else {
		// 	$pusher_var['event'] = 'MG';
		// }

		foreach ($cp as $key => $value) {
			$check_points[$value->movement] = $value;
		}

		// dd($check_points);
		// var_dump($check_points);
		// die();

		return View::make('mobile/overview', compact('containers', 'pusher_var', 'check_points', 'role'));
	}

	public function getActiveByContainerNo()
	{
		$input = Input::all();
		$container_no = $input['container_no'];

		if($ctn = $this->containerRepository->getActiveMovementByContainerNo($container_no)) {
			return json_encode($ctn);
		} else {
			return 0;
		}

	}

	/**
	 * Show the form for creating a new resource.
	 * GET /mobile/create
	 *
	 * @return Response
	 */
	public function confirmation()
	{
		//dd('Confirmation');

		$input = Input::all();

		// dd($input);

		$result = $this->execute(ConfirmContainerCommand::class, $input);

		// return 'Successfully confirmed!';
		Flash::success("Container(s) confirmed!");
		return Redirect::route('mobile');
		// return $result;
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /mobile
	 *
	 * @return Response
	 */
	public function pwdCheck()
	{
		$input = Input::all();

		if(Hash::check($input['password'], Auth::user()->password))
		{
			// return true
			return 1;
		}

		// return false
		return 0;
	}


	public function refresh()
	{
		$role = Input::get('cp');
		$ctn = [];

		//$role = 'CY3';

		$containers = $this->containerRepository->getContainersToConfirmByRole($role);

		foreach($containers as $container)
		{
	        $ctn[] = [
	            "id"=> $container->id . ',' . $container->content . ',' . $container->current_movement . ',' . $container->workorders->last()->movement,
	            "container_no"=> $container->container_no,
	            "vehicle"=> $container->workorders->last()->pivot->vehicle,
	            "lifter"=> $container->workorders->last()->pivot->lifter
	        ];			
		}

		//dd($ctn);
		return json_encode($ctn);

	}

	/**
	 * Display the specified resource.
	 * GET /mobile/{id}
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
	 * GET /mobile/{id}/edit
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
	 * PUT /mobile/{id}
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
	 * DELETE /mobile/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
<?php namespace LLPM\Repositories;

use Auth;
use ContainerWorkorderConfirmation;
use ContainerConfirmation;
use DB;

class ContainerWorkorderConfirmationRepository {

	public function confirmationEntry($container, $operator, $confirmed_at)
	{
		$containerConfirmationId = ContainerConfirmation::where('container_id', $container->id)
			->where('workorder_id', $container->workorders->last()->id)
			->first()
			->id;

		ContainerWorkorderConfirmation::create([
			'container_id'=>$container->id,
			'container_no'=>$container->container_no,
			'workorder_id'=>$container->workorders->last()->id,
			'container_workorder_id'=>$containerConfirmationId,
			'confirmed_by'=> Auth::user()->id,
			'operator_id'=>$operator,
			'role'=> $container->to_confirm_by,
			'confirmed_at'=> $confirmed_at
		]);

	}

	public function getAllByWorkorders($workorder_list)
	{
		return ContainerWorkorderConfirmation::with(['container', 'user', 'containerConfirmation'])->whereIn('workorder_id', $workorder_list)->orderBy('confirmed_at')->get();
	}

	public function getAllByDateAndLocations($date, $locations = null)
	{
		if($locations == null) {
			// return ContainerWorkorderConfirmation::with(['container', 'containerConfirmation','workorder'])
			// 		->where('confirmed_at', 'like', $date->format('Y-m-d') . '%')
			// 		->orderBy('confirmed_at')
			// 		->get();

			return DB::table('container_workorder_confirmation')
	        	->leftJoin('containers', 'containers.id', '=', 'container_workorder_confirmation.container_id')
	        	->leftJoin('workorders', 'workorders.id', '=', 'container_workorder_confirmation.workorder_id')
	        	->leftJoin('container_workorder', 'container_workorder.id', '=', 'container_workorder_confirmation.container_workorder_id')
	        	->leftJoin('vessel_schedule', 'vessel_schedule.id', '=', 'workorders.vessel_schedule_id')
	        	->leftJoin('vessels', 'vessels.id', '=', 'vessel_schedule.vessel_id')
	        	->select('container_workorder_confirmation.confirmed_at', 'containers.container_no', 'containers.size', 'container_workorder_confirmation.role', 'workorders.id as workorder_id', 'workorders.movement', 'container_workorder.content', 'container_workorder.vehicle', 'container_workorder.lifter', 'vessels.name as vessel_name', 'vessel_schedule.voyage_no_arrival', 'vessel_schedule.voyage_no_departure')
	        	->where('container_workorder_confirmation.confirmed_at', 'like', $date->format('Y-m-d') . '%')
	        	->orderBy('container_workorder_confirmation.confirmed_at')
	        	->get();			
		}

		return ContainerWorkorderConfirmation::with(['container', 'containerConfirmation'])
				->where('confirmed_at', 'like', $date->format('Y-m-d') . '%')
				->whereIn('role', $locations)
				->orderBy('confirmed_at')
				->get();

	
	}

	public function getAll()
	{
		return ContainerWorkorderConfirmation::with('user', 'operator', 'container', 'workorder', 'containerConfirmation')->orderBy('confirmed_at', 'desc')->get();
	}
}
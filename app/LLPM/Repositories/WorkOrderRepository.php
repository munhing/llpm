<?php

namespace LLPM\Repositories;

use WorkOrder;
use Paginator;
use Carbon\Carbon;

class WorkOrderRepository {

	public function save(WorkOrder $workOrder)
	{
		return $workOrder->save();
	}

	public function getById($id)
	{
		return WorkOrder::find($id);
	}

	public function getDetailsById($id)
	{
		return WorkOrder::with(['handler', 'carrier', 'vesselSchedule', 
				'containers' => function($query){
					$query->orderBy('container_no');
				}
			])
			->find($id);
	}

	public function getAllToday()
	{
		return WorkOrder::where('date', 'like', Carbon::now()->format('Y-m-d') . '%')
				->get();
	}

	public function getAllByMonth($month, $movement = null)
	{
		if($movement) {
			return WorkOrder::with('handler', 'carrier', 'vesselSchedule')
					->where('date', 'like', $month . '%')
					->where('movement', $movement)
					->orderBy('workorders.id', 'desc')
					->get();
		}

		return WorkOrder::with('handler', 'carrier', 'vesselSchedule')
				->where('date', 'like', $month . '%')
				->orderBy('workorders.id', 'desc')
				->get();
	}

	public function getAllByScheduleId($schedule_id, $movement)
	{
		// dd($movement);
		if($movement != '') {
			return WorkOrder::where('vessel_schedule_id', $schedule_id)
					->where('movement', $movement)
					->orderBy('workorders.date', 'desc')
					->get();			
		}
		return WorkOrder::where('vessel_schedule_id', $schedule_id)
				->orderBy('workorders.date', 'desc')
				->get();
	}

	// public function getByWorkOrderNo($workorder_no)
	// {
	// 	return WorkOrder::where('workorder_no', $workorder_no)->first();
	// }

	public function cancelContainer($workorder_id, $container_id)
	{
		$workorder = $this->getById($workorder_id);
		$workorder->containers()->detach($container_id);

		return true;
	}

	public function search($workorder_no, $page = 1)
	{
		Paginator::setCurrentPage($page);

		return WorkOrder::where('id', 'like', '%' . $workorder_no . '%')
				->orderBy('workorders.date', 'desc')
				->paginate(10);
	}

	public function api($query)
	{
		return WorkOrder::where('id', 'like', $query . '%')
				->orderBy('workorders.date')
				->take(10)->get();		
	}
}
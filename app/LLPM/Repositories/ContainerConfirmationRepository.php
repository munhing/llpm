<?php

namespace LLPM\Repositories;

use ContainerConfirmation;
use Carbon\Carbon as Carbon;

class ContainerConfirmationRepository {

	public function save(ContainerConfirmation $containerConfirmation)
	{
		return $containerConfirmation->save();
	}

	public function getById($id)
	{
		return ContainerConfirmation::with('container', 'workorder')->find($id);
	}

	public function getByContainerAndWorkorderId($container_id, $workorder_id)
	{
		return ContainerConfirmation::where('container_id',$container_id)->where('workorder_id', $workorder_id)->first();
	}

	public function getByWorkOrderId($id)
	{
		return ContainerConfirmation::with(['container', 'user'])->where('workorder_id', '=', $id)->get();
	}

	public function getAll()
	{
		// return ContainerConfirmation::with('container', 'workorder')
		// 								->get();

		return ContainerConfirmation::with('container', 'workorder')
				->selectRaw('container_workorder.*, containers.container_no, workorders.workorder_no')
		       	->join('containers', 'container_workorder.container_id', '=', 'containers.id')
		       	->join('workorders', 'container_workorder.workorder_id', '=', 'workorders.id')
		       	->where('confirm', 0)
		       	->orderBy('containers.container_no')
		       	->get();										
	}

	public function getAllConfirmedByDate($date)
	{
		return ContainerConfirmation::with('container')
				->where('updated_at', 'like', $date->format('Y-m-d') . '%')
				->where('confirmed', 1)
				->orderBy('updated_at')
				->get();
	}

	public function getAllConfirmedByDateAndMovements($date, $movements)
	{
		// dd($movements);
		if($movements == null) {
			return $this->getAllConfirmedByDate($date);
		}

		return ContainerConfirmation::with('container')
				->where('updated_at', 'like', $date->format('Y-m-d') . '%')
				->where('confirmed', 1)
				->whereIn('movement', $movements)
				->orderBy('updated_at')
				->get();
	}

	public function getPendingByContainerId($container_id)
	{
		return ContainerConfirmation::where('container_id', $container_id)
										->where('confirm', 0)
										->first();
	}

	public function getAllPending()
	{
		return ContainerConfirmation::where('confirmed', 0)
										->get();
	}

	public function getPendingHERO()
	{
		return ContainerConfirmation::where('confirmed', 0)
									->wherein('movement', ['HE', 'RO-1', 'RO-3'])
									->get();
	}

	public function getAllImportExport($year)
	{
		return ContainerConfirmation::selectRaw('count(*) as container_count, month(container_workorder.confirmed_at) as c_month, containers.size, container_workorder.movement')
				->join('containers', 'container_workorder.container_id', '=', 'containers.id')
				->whereYear('container_workorder.confirmed_at', '=', $year)
		       	->where('container_workorder.confirmed', 1)
		       	->whereIn('container_workorder.movement', ['HI', 'HE'])
		       	->groupBy('containers.size')
		       	->groupBy('c_month')
		       	->groupBy('container_workorder.movement')
		       	->get();	       									
	}

	public function getTotalContainersTransferToCY3($year)
	{
        return ContainerConfirmation::selectRaw('count(*) as container_count, month(container_workorder.confirmed_at) as c_month, containers.size, container_workorder.movement')
            ->join('containers', 'container_workorder.container_id', '=', 'containers.id')
            ->whereYear('container_workorder.confirmed_at', '=', $year)
            ->where('container_workorder.confirmed', 1)
            ->where('container_workorder.movement', '=', 'TF-1-3')
            ->groupBy('containers.size')
            ->groupBy('c_month')
            ->get();
	}	

    public function getTotalContainersTransferToCY1($year)
    {
        return ContainerConfirmation::selectRaw('count(*) as container_count, month(container_workorder.confirmed_at) as c_month, containers.size, container_workorder.movement')
            ->join('containers', 'container_workorder.container_id', '=', 'containers.id')
            ->whereYear('container_workorder.confirmed_at', '=', $year)
            ->where('container_workorder.confirmed', 1)
            ->where('container_workorder.movement', '=', 'TF-3-1')
            ->groupBy('containers.size')
            ->groupBy('c_month')
            ->get();
    }       
}
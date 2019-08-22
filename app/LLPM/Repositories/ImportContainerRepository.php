<?php namespace LLPM\Repositories;

use ImportContainer;
use ImportCargo;

class ImportContainerRepository {

	public function save(ImportContainer $importContainer)
	{
		return $importContainer->save();
	}

	public function getAllContainer()
	{
		return ImportContainer::all();
	}

	public function getAllActive()
	{
		return ImportContainer::whereIn('status', [1,2,3])
				->orderBy('container_no')
				->get();
	}

	public function getActiveByContainerNo($container_no)
	{
		return ImportContainer::where('container_no', $container_no)
				->whereIn('status', [1,2,3])
				->orderBy('container_no')
				->get()
				->first();
	}

	public function attachToVesselSchedule($importContainer, $vessel_schedule_id)
	{
		return $importContainer->schedule()->attach($vessel_schedule_id);
	}

	public function getAll($vessel_schedule_id)
	{
		return ImportContainer::where('vessel_schedule_id', $vessel_schedule_id)
				->orderBy('container_no')
				->get();
	}

	public function getById($container_id)
	{
		return ImportContainer::find($container_id);
	}

	// public function getByContainerNoAndScheduleId($containerNo, $vesselScheduleId)
	// {
	// 	return ImportContainer::where('container_no', $containerNo)
	// 		->where('vessel_schedule_id', $vesselScheduleId)
	// 		->first();
	// }

	public function getAllByScheduleId($vesselScheduleId)
	{
		return ImportContainer::where('vessel_schedule_id', $vesselScheduleId)
			->orderBy('container_no')
			->get();		
	}

	public function updateContainerContent($container_id, $content)
	{
		$container = $this->getById($container_id);
		$container->content = $content;
		$this->save($container);
	}
	
	// public function getById($id)
	// {
	// 	return VesselSchedule::with('vessel')->find($id);
	// }

		// $reports = Report::with('client')->selectRaw("reports.*, clients.name, (`next_inspection`) > (NOW())  AS `status`")
		//        ->join('clients', 'reports.client_id', '=', 'clients.id')
		//        ->orderBy($sortby, $order)
		//        ->paginate(20);
}
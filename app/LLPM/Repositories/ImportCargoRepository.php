<?php namespace LLPM\Repositories;

use ImportCargo;
use ImportContainer;

class ImportCargoRepository {

	public function save(ImportCargo $importCargo)
	{
		return $importCargo->save();
	}

	public function getByBlNo($blNo)
	{
		return ImportCargo::where('bl_no', $blNo)
			->first();
	}

	public function getById($id)
	{
		return ImportCargo::with('schedule', 'consignor', 'consignee', 'importContainers')
			->find($id);
	}

	public function getAllByScheduleId($vesselScheduleId)
	{
		return ImportCargo::with('consignor', 'consignee', 'importContainers')
			->where('vessel_schedule_id', $vesselScheduleId)
			->orderBy('bl_no')
			->get();		
	}

	public function attachToVesselSchedule($importCargo, $vessel_schedule_id)
	{
		return $importCargo->schedule()->attach($vessel_schedule_id);
	}

	public function attachToContainer(ImportCargo $cargo, ImportContainer $container)
	{
		// check whether both id's already listed in the pivot table
		if (!$cargo->importContainers->contains($container->id)) {
	    	$cargo->importContainers()->attach($container);
		}
	}

	public function detachFromContainer(ImportCargo $cargo, ImportContainer $container)
	{
	    $cargo->importContainers()->detach($container);
	}

}
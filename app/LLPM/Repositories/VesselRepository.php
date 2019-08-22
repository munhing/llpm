<?php

namespace LLPM\Repositories;

use Vessel;

class VesselRepository {

	public function save(Vessel $vessel)
	{
		return $vessel->save();
	}

	public function getAll()
	{
		return Vessel::orderBy('name')->get();
	}

	public function searchByName($q)
	{
		// select2 will only be populated with id:text
		return Vessel::selectRaw('id, name as text')
			->where('name', 'LIKE', "%$q%")
			->orderBy('name')
			->get();
	}

}
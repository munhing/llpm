<?php 

namespace LLPM\Repositories;

use Country;

class CountryRepository {

	public function save(VesselSchedule $vesselSchedule)
	{
		return $vesselSchedule->save();
	}

	public function getAll()
	{
		return Country::all();
	}
}
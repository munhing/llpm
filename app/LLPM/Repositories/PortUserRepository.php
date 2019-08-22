<?php namespace LLPM\Repositories;

use PortUser;
use DB;

class PortUserRepository {

	public function save(PortUser $portUser)
	{
		return $portUser->save();
	}

	public function getAll()
	{
		return PortUser::orderBy('name')->get();
	}

	public function getById($id)
	{
		return PortUser::find($id);
	}

	public function searchByName($q)
	{
		// select2 will only be populated with id:text
		return PortUser::selectRaw('id, name as text')
			->where('name', 'LIKE', "%$q%")
			->orderBy('name')
			->get();

		// return DB::table('port_users')
		// 	->select(DB::raw('id, name as text'))
		// 	->where('name', 'LIKE', "%$q%")
		// 	->orderBy('name')
		// 	->get();
	}

}
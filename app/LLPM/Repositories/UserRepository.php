<?php 

namespace LLPM\Repositories;

use User;

class UserRepository {

	public function save(User $user)
	{
		return $user->save();
	}

	public function getAll()
	{
		return User::with('roles')->orderBy('username')->get();
	}

	public function getAllStaff()
	{
		return User::with('roles')->where('is_staff', 1)->orderBy('username')->get();
	}

	public function getAllPortUsers()
	{
		return User::with('roles')->where('is_staff', '!=',1)->orderBy('username')->get();
	}

	public function getPendingPortUsers()
	{
		return User::where('is_staff', 0)->orderBy('username')->get();
	}

	public function assignRole($role)
	{
		return $this->roles()->attach($role);
	}

	public function approvePortUser($portuser_id)
	{
		$portuser = User::find($portuser_id);
		$portuser->is_staff = 2;
		$portuser->save();

		return $portuser;
	}	

	public function disablePortUser($portuser_id)
	{
		$portuser = User::find($portuser_id);
		$portuser->is_staff = 3;
		$portuser->save();

		return $portuser;
	}

	public function enablePortUser($portuser_id)
	{
		$portuser = User::find($portuser_id);
		$portuser->is_staff = 2;
		$portuser->save();

		return $portuser;
	}	
}
<?php namespace LLPM\Repositories;

use Role;

class RoleRepository {

	public function save(Role $role)
	{
		return $role->save();
	}

	public function getById($id)
	{
		return Role::with('permissions')->find($id);
	}

	public function getByRole($role)
	{
		return Role::with('users')->where('role', $role)->first();	
	}

	public function getAll()
	{
		return Role::orderBy('role')->get();
	}

	public function updatePermission($role_id, $permit_id)
	{
		$role = $this->getById($role_id);

		if($role->permissions->contains($permit_id)) {
			$role->permissions()->detach($permit_id);
		} else {
			$role->permissions()->attach($permit_id);
		}
	}
}
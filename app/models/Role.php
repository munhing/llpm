<?php

use Laracasts\Commander\Events\EventGenerator;
use LLPM\Users\Events\RoleWasRegistered;

class Role extends \Eloquent {

	use EventGenerator;

	protected $fillable = ['role', 'description'];

	public function users()
	{
		return $this->belongsToMany('User');
	}

	public function permissions()
	{
		return $this->belongsToMany('Permission');
	}

	public static function register($role, $description)
	{
		$role = new static(compact('role', 'description'));

		$role->raise(new RoleWasRegistered($role));

		return $role;
	}	
}
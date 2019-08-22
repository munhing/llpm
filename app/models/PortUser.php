<?php

use Laracasts\Commander\Events\EventGenerator;
use LLPM\PortUser\Events\PortUserWasRegistered;

class PortUser extends \Eloquent {

	use EventGenerator;

	protected $table = 'port_users';

	protected $fillable = ['name'];

	public function exportConsignors() 
	{
		return $this->hasMany('ImportCargo', 'consignor_id');
	}

	public function exportConsignees() 
	{
		return $this->hasMany('ImportCargo', 'consignee_id');
	}

	public static function register($name)
	{
		$portUser = new static(compact('name'));

		$portUser->raise(new PortUserWasRegistered($portUser));

		return $portUser;
	}

}
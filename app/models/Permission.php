<?php

class Permission extends \Eloquent {

	protected $fillable = ['route_name', 'description'];

	public function roles()
	{
		return $this->belongsToMany('Role');
	}	
}
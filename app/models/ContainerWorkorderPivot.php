<?php

use Illuminate\Database\Eloquent\Relations\Pivot;

class ContainerWorkorderPivot extends Pivot {

	protected $dates = ['confirmed_at'];

	public function user()
	{
		return $this->belongsTo('User', 'confirmed_by');
	}		
}
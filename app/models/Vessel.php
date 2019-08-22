<?php

use Laracasts\Commander\Events\EventGenerator;
use LLPM\Vessels\Events\VesselWasRegistered;

class Vessel extends \Eloquent {

	use EventGenerator;

	protected $fillable = ['name'];

	public function schedule()
	{
		return $this->hasMany('VesselSchedule');
	}	

	public static function register($name)
	{
		$vessel = new static(compact('name'));

		$vessel->raise(new VesselWasRegistered($vessel));

		return $vessel;
	}		
}
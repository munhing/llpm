<?php

use Laracasts\Commander\Events\EventGenerator;

class Country extends \Eloquent {

	use EventGenerator;

	protected $fillable = ['iso','name','printable_name','iso3','numcode'];

	protected $table = "country";

	// public function schedule()
	// {
	// 	return $this->hasMany('VesselSchedule');
	// }	

	// public static function register($name)
	// {
	// 	$vessel = new static(compact('name'));

	// 	$vessel->raise(new VesselWasRegistered($vessel));

	// 	return $vessel;
	// }		
}
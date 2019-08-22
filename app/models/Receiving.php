<?php

use Laracasts\Commander\Events\EventGenerator;
// use LLPM\Schedule\Events\VesselScheduleWasRegistered;
// use LLPM\Schedule\Events\VesselScheduleWasUpdated;

class Receiving extends \Eloquent {

	use EventGenerator;

	protected $table = 'receiving';

	protected $fillable = ['date'];

	protected $dates = array('date');

	public function containers()
	{
		return $this->hasMany('Container', 'receiving_id');
	}	

	public function cargoes()
	{
		return $this->hasMany('Cargo', 'receiving_id');
	}	

	public static function register($date)
	{
		$receiving = new static(compact('date'));

		//$receiving->raise(new ReceivingWasRegistered($receiving));

		return $receiving;
	}	

	public static function edit($id, $date)
	{
		$receiving = static::find($id);

        $receiving->date = $date;

		//$receiving->raise(new VesselScheduleWasUpdated($receiving));

		return $receiving;
	}		
}

        
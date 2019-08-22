<?php

use Laracasts\Commander\Events\EventGenerator;
use LLPM\Schedule\Events\VesselScheduleWasRegistered;
use LLPM\Schedule\Events\VesselScheduleWasUpdated;

class VesselSchedule extends \Eloquent {

	use EventGenerator;

	protected $table = 'vessel_schedule';

	protected $fillable = ['registered_vessel_id', 'vessel_id', 'portuser_id', 'voyage_no_arrival', 'voyage_no_departure', 'eta', 'etd', 'mt_arrival', 'mt_departure', 'm3_arrival', 'm3_departure'];

	protected $dates = array('eta', 'etd');

	public function vessel()
	{
		return $this->belongsTo('Vessel', 'vessel_id');
	}		

	public function portUser()
	{
		return $this->belongsTo('PortUser', 'portuser_id');
	}	

	public function importContainers()
	{
		return $this->hasMany('Container', 'import_vessel_schedule_id');
	}	

	public function importCargoes()
	{
		return $this->hasMany('Cargo', 'import_vessel_schedule_id');
	}

	public function exportContainers()
	{
		return $this->hasMany('Container', 'export_vessel_schedule_id');
	}	

	public function exportCargoes()
	{
		return $this->hasMany('Cargo', 'export_vessel_schedule_id');
	}

        public function getVesselVoyageAttribute()
        {
                return $this->vessel->name . " V." . $this->voyage_no_arrival . " | " . $this->voyage_no_departure;
        }

        public function getVesselVoyageExportAttribute()
        {
                return $this->vessel->name . " V." . $this->voyage_no_departure;
        }

	public static function register($registered_vessel_id, $vessel_id, $voyage_no_arrival, $portuser_id, $eta, $etd)
	{
		$vesselSchedule = new static(compact('registered_vessel_id', 'vessel_id', 'voyage_no_arrival', 'portuser_id', 'eta', 'etd'));

		$vesselSchedule->raise(new VesselScheduleWasRegistered($vesselSchedule));

		return $vesselSchedule;
	}	

	public static function edit($id, $vessel_id, $portuser_id, $voyage_no_arrival, $voyage_no_departure, $eta, $etd, $mt_arrival, $mt_departure, $m3_arrival, $m3_departure)
	{
		$vesselSchedule = static::find($id);

        $vesselSchedule->vessel_id = $vessel_id;
        $vesselSchedule->portuser_id = $portuser_id;
        $vesselSchedule->voyage_no_arrival = $voyage_no_arrival;
        $vesselSchedule->voyage_no_departure = $voyage_no_departure;
        $vesselSchedule->eta = $eta;
        $vesselSchedule->etd = $etd;
        $vesselSchedule->mt_arrival = $mt_arrival;
        $vesselSchedule->mt_departure = $mt_departure;
        $vesselSchedule->m3_arrival = $m3_arrival;
        $vesselSchedule->m3_departure = $m3_departure;

		$vesselSchedule->raise(new VesselScheduleWasUpdated($vesselSchedule));

		return $vesselSchedule;
	}		
}

        

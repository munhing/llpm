<?php

use Laracasts\Commander\Events\EventGenerator;
use LLPM\Schedule\Events\ImportContainerWasRegistered;

class ImportContainer extends \Eloquent {

	use EventGenerator;

	protected $table = 'containers';

	protected $fillable = ['container_no', 'size', 'content', 'status'];

	// public function schedule()
	// {
	// 	return $this->belongsTo('VesselSchedule');
	// }		

	public function importCargoes()
	{
		//belongsToMany('related_model_name','pivot_table_name','pivot_column_name_refering_to_this_model','pivot_column_name_refering_to_related_model')
		// The third argument should relate to this model which is container's id
		return $this->belongsToMany('ImportCargo', 'cargo_container', 'container_id', 'cargo_id');
	}

	public function schedule()
	{
		return $this->belongsToMany('VesselSchedule', 'container_schedule', 'container_id', 'vessel_schedule_id');
	}

	public static function register($container_no, $size, $content, $status)
	{
		$importContainer = new static(compact('container_no', 'size', 'content', 'status'));

		$importContainer->raise(new ImportContainerWasRegistered($importContainer));

		return $importContainer;
	}	

}
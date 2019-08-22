<?php

use Laracasts\Commander\Events\EventGenerator;
use LLPM\Containers\Events\ContainerWasRegistered;
use LLPM\Containers\Events\ContainerWasUpdated;

class Container extends \Eloquent {

	use EventGenerator;

	protected $table = 'containers';

	protected $fillable = ['container_no', 'size', 'content', 'location', 'status', 'current_movement', 'dl_check', 'm_content', 'import_vessel_schedule_id', 'export_vessel_schedule_id', 'receiving_id', 'container_location', 'container_status'];

	public static function boot()
	{
		static::saved(function($sql){
			//Log::info($q);
			//dd($sql->toArray());
		});
	}

	public function newPivot(Eloquent $parent, array $attributes, $table, $exists)
	{
	    if ($parent instanceof WorkOrder) return new ContainerWorkorderPivot($parent, $attributes, $table, $exists);

	    return parent::newPivot($parent, $attributes, $table, $exists);
	}

	public function import_schedule()
	{
		return $this->belongsTo('VesselSchedule', 'import_vessel_schedule_id');
	}		

	public function export_schedule()
	{
		return $this->belongsTo('VesselSchedule', 'export_vessel_schedule_id');
	}	

    public function getVesselScheduleImportAttribute()
    {
    	// if(is_null($this->import_schedule)) {
    	// 	return '';
    	// }

        return $this->import_schedule->vessel->name . " V." . $this->import_schedule->voyage_no_arrival;
    }

    public function getVesselScheduleExportAttribute()
    {
    	if(is_null($this->export_schedule)) {
    		return '';
    	}

        return $this->export_schedule->vessel->name . " V." . $this->export_schedule->voyage_no_departure;
    }
        
	public function receiving()
	{
		return $this->belongsTo('Receiving', 'receiving_id');
	}

	public function cargoes()
	{
		return $this->belongsToMany('Cargo', 'cargo_container', 'container_id', 'cargo_id')->withTimestamps();;
	}

	public function m_cargoes()
	{
		return $this->belongsToMany('Cargo', 'm_cargo_container', 'container_id', 'cargo_id')->withTimestamps();;
	}

	public function workorders()
	{
		// return $this->belongsToMany('WorkOrder', 'container_workorder', 'container_id', 'workorder_id')
		// 	->withTimestamps()
		// 	->withPivot('movement', 'content', 'vehicle', 'lifter', 'confirmed', 'confirmed_by', 'confirmed_at', 'updated_at');

		return $this->belongsToMany('WorkOrder', 'container_workorder', 'container_id', 'workorder_id')
			->withTimestamps()
			->withPivot('movement', 'content', 'vehicle', 'lifter', 'remark', 'confirmed', 'confirmed_by', 'confirmed_at', 'updated_at')
			->leftjoin('users', function($join) {
			      	$join->on('container_workorder.confirmed_by','=','users.id');
			    	})
			->select('workorders.*', 'users.name AS users_name');
	}		

	public static function register($container_no, $size, $content, $status, $dl_check, $m_content, $import_vessel_schedule_id)
	{
		$container = new static(compact('container_no', 'size', 'content', 'status', 'dl_check', 'm_content','import_vessel_schedule_id'));

		//$container->raise(new ContainerWasRegistered($container));

		return $container;
	}	

	public static function registerReceiving($container_no, $size, $content, $status, $dl_check, $receiving_id)
	{
		$container = new static(compact('container_no', 'size', 'content', 'status', 'dl_check', 'receiving_id'));

		//$container->raise(new ContainerWasRegistered($container));

		return $container;
	}	

	public static function editBasic($id, $container_no, $size)
	{
		$container = static::find($id);

        $container->container_no = $container_no;
        $container->size = $size;

		// $container->raise(new ContainerWasUpdated($container));

		return $container;
	}

	public static function edit($id, $container_no, $size, $content, $location, $status, $current_movement)
	{
		$container = static::find($id);

        $container->container_no = $container_no;
        $container->size = $size;
        $container->content = $content;
        $container->location = $location;
        $container->status = $status;
        $container->current_movement = $current_movement;

		$container->raise(new ContainerWasUpdated($container));

		return $container;
	}		

	public static function editAfterConfirmation($contaner_id, $location, $status, $current_movement)
	{
		$container = static::find($contaner_id);

        $container->location = $location;
        $container->status = $status;
        $container->current_movement = $current_movement;

		//$container->raise(new ContainerWasUpdated($container));

		return $container;
	}			
}

        
<?php

use Laracasts\Commander\Events\EventGenerator;
use LLPM\WorkOrders\Events\WorkOrderWasRegistered;
use LLPM\WorkOrders\Events\WorkOrderWasUpdated;

class WorkOrder extends \Eloquent {

	use EventGenerator;

	protected $table = 'workorders';

	protected $fillable = ['movement', 'date', 'carrier_id', 'handler_id', 'agent_id', 'vessel_schedule_id', 'container_location', 'container_status', 'who_is_involved', 'created_by', 'finalized', 'bond_rent', 'storage_charges', 'handling_charges'];

	protected $dates = array('date');

	public function newPivot(Eloquent $parent, array $attributes, $table, $exists)
	{
	    if ($parent instanceof Container) return new ContainerWorkorderPivot($parent, $attributes, $table, $exists);

	    return parent::newPivot($parent, $attributes, $table, $exists);
	}

	public function containers()
	{
		return $this->belongsToMany('Container', 'container_workorder', 'workorder_id', 'container_id')
			->withTimestamps()
			->withPivot('movement', 'content', 'vehicle', 'lifter', 'remark', 'confirmed', 'confirmed_by', 'confirmed_at', 'updated_at')
			->leftjoin('users', function($join) {
			      	$join->on('container_workorder.confirmed_by','=','users.id');
			    })
			->select('containers.*', 'users.name AS users_name');
	}		

	public function handler()
	{
		return $this->belongsTo('PortUser', 'handler_id');
	}

	public function carrier()
	{
		return $this->belongsTo('PortUser', 'carrier_id');
	}

	public function vesselSchedule()
	{
		return $this->belongsTo('VesselSchedule', 'vessel_schedule_id');
	}

	public function user()
	{
		return $this->belongsTo('User', 'created_by');
	}

	public function getCarrier()
	{
		if ($this->movement == 'HI')
		{
			return " MV. " . $this->vesselSchedule->vessel->name . " v." . $this->vesselSchedule->voyage_no_arrival;
		}

		if ($this->movement == 'HE')
		{
			return " MV. " . $this->vesselSchedule->vessel->name . " v." . $this->vesselSchedule->voyage_no_departure;
		}

		return $this->carrier->name;
	}

	public static function register($movement, $date, $carrier_id, $handler_id, $vessel_schedule_id, $container_location, $container_status, $who_is_involved, $created_by)
	{
		$workorder = new static(compact('movement', 'date', 'carrier_id', 'handler_id', 'vessel_schedule_id', 'container_location', 'container_status', 'who_is_involved', 'created_by'));

		//$workorder->raise(new WorkOrderWasRegistered($workorder));

		return $workorder;
	}	

	public static function edit($id, $movement, $date, $carrier_id, $handler_id, $vessel_schedule_id)
	{
		$workorder = static::find($id);

        $workorder->movement = $movement;
        $workorder->date = $date;
        $workorder->carrier_id = $carrier_id;
        $workorder->handler_id = $handler_id;
        $workorder->vessel_schedule_id = $vessel_schedule_id; 

		$workorder->raise(new WorkOrderWasUpdated($workorder));

		return $workorder;
	}

	public static function finalize($id)
	{
		$workorder = static::find($id);

        $workorder->finalized = 1; 

		return $workorder;
	}		
}

        
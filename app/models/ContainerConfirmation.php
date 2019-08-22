<?php

use Laracasts\Commander\Events\EventGenerator;

class ContainerConfirmation extends \Eloquent {

	use EventGenerator;

	protected $table = 'container_workorder';

	protected $fillable = ['content', 'vehicle', 'lifter', 'remark', 'confirmed', 'confirmed_by', 'confirmed_at'];

	public function container()
	{
		return $this->belongsTo('Container', 'container_id');
	}		

	public function workOrder()
	{
		return $this->belongsTo('WorkOrder', 'workorder_id');
	}	

	public function user()
	{
		return $this->belongsTo('User', 'confirmed_by');
	}

	public static function confirm($container_id, $confirmed, $confirmed_by, $confirmed_at)
	{
		$confirmation = static::where('container_id',$container_id)->where('confirmed', 0)->first();

        $confirmation->confirmed = $confirmed;
        $confirmation->confirmed_by = $confirmed_by;
        $confirmation->confirmed_at = $confirmed_at;

		//$confirmation->raise(new ContainerWasUpdated($container));

		return $confirmation;
	}

	public static function update_vehicle_lifter($container_id, $vehicle, $lifter)
	{
		$confirmation = static::where('container_id',$container_id)->where('confirmed', 0)->first();

        $confirmation->vehicle = $vehicle;
        $confirmation->lifter = $lifter;

		//$confirmation->raise(new ContainerWasUpdated($container));

		return $confirmation;
	}

	public static function update_bypass_remark($container_id)
	{
		$confirmation = static::where('container_id',$container_id)->where('confirmed', 0)->first();

        $confirmation->remark = 'BYPASS';

		//$confirmation->raise(new ContainerWasUpdated($container));

		return $confirmation;
	}
}

        
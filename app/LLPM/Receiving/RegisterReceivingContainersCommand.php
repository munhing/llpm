<?php namespace LLPM\Receiving;

class RegisterReceivingContainersCommand {

    
	public $containers;
	public $export_vessel_schedule_id;

    public function __construct($containers, $export_vessel_schedule_id = 0)
    {
    	$this->containers = $containers;
    	$this->export_vessel_schedule_id = $export_vessel_schedule_id;
    }

}
<?php namespace LLPM\Schedule;

class AssociateContainersWithCargoCommand {

    
	public $containers;
	public $import_vessel_schedule_id;
	public $cargo_id;

    public function __construct($containers, $import_vessel_schedule_id, $cargo_id)
    {
    	$this->containers = $containers;
    	$this->import_vessel_schedule_id = $import_vessel_schedule_id;
    	$this->cargo_id = $cargo_id;
    }

}
<?php namespace LLPM\Schedule;

class RegisterImportContainersCommand {

    
	public $containers;
	public $import_vessel_schedule_id;
	public $receiving_id;

    public function __construct($containers, $import_vessel_schedule_id, $receiving_id)
    {
    	$this->containers = $containers;
    	$this->import_vessel_schedule_id = $import_vessel_schedule_id;
    	$this->receiving_id = $receiving_id;
    }

}
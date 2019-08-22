<?php namespace LLPM\Schedule;

class DetachContainerFromCargoCommand {

    
	public $schedule_id;
	public $cargo_id;
	public $container_id;

    public function __construct($schedule_id, $cargo_id, $container_id)
    {
    	$this->schedule_id = $schedule_id;
    	$this->cargo_id = $cargo_id;
    	$this->container_id = $container_id;
    }

}
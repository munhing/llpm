<?php 

namespace LLPM\Schedule;

class UnlinkContainerCommand {

    
	public $container_id;
	public $cargo_id;

    public function __construct($container_id, $cargo_id)
    {
    	$this->container_id = $container_id;
    	$this->cargo_id = $cargo_id;
    }

}
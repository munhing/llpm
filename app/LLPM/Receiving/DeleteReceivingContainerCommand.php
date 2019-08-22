<?php namespace LLPM\Receiving;

class DeleteReceivingContainerCommand {

    
	public $container_id;

    public function __construct($container_id)
    {
    	$this->container_id = $container_id;
    }

}
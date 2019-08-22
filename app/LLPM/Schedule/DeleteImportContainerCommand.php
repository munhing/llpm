<?php

namespace LLPM\Schedule;

class DeleteImportContainerCommand {

    
	public $container_id;

    public function __construct($container_id)
    {
    	$this->container_id = $container_id;
    }

}
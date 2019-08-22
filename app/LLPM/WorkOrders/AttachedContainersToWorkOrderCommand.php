<?php 

namespace LLPM\WorkOrders;

class AttachedContainersToWorkOrderCommand {

    
	public $containers;
	public $workorder_id;

    public function __construct($containers, $workorder_id)
    {
    	$this->containers = $containers;
    	$this->workorder_id = $workorder_id;
    }

}
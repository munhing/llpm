<?php namespace LLPM\WorkOrders;

class CancelContainerCommand {

	public $workorder_id;
	public $container_id;

    /**
     */
    public function __construct($workorder_id, $container_id)
    {

		$this->workorder_id = $workorder_id;
		$this->container_id = $container_id;		

    }

}
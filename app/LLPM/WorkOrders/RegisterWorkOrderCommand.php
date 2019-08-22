<?php namespace LLPM\WorkOrders;

class RegisterWorkOrderCommand {

	public $type;
	public $handler_id;
	public $carrier_id;
	public $containers;

    /**
     */
    public function __construct($type, $handler_id, $carrier_id, $containers)
    {

		$this->type = $type;
		$this->handler_id = $handler_id;		
		$this->carrier_id = $carrier_id;
		$this->containers = $containers;
    }

}
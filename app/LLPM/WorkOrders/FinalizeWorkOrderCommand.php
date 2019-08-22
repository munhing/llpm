<?php

namespace LLPM\WorkOrders;

class FinalizeWorkOrderCommand {

	public $workorder_id;

    /**
     */
    public function __construct($workorder_id)
    {
		$this->workorder_id = $workorder_id;
    }

}
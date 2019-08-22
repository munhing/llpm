<?php

namespace LLPM\WorkOrders;

class UpdateWorkOrderWithAgentCommand {

	public $workorder_id;
	public $agent_id;

    /**
     */
    public function __construct($workorder_id, $agent_id)
    {
		$this->workorder_id = $workorder_id;
		$this->agent_id = $agent_id;
    }

}
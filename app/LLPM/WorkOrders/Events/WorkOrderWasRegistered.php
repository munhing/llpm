<?php namespace LLPM\WorkOrders\Events;

use WorkOrder;

class WorkOrderWasRegistered {

    public $workOrder;

    public function __construct(WorkOrder $workOrder) /* or pass in just the relevant fields */
    {
        $this->workOrder = $workOrder;
    }

}
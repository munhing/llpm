<?php

namespace LLPM\WorkOrders;

use Illuminate\Support\Facades\Log;
use LLPM\Repositories\WorkOrderRepository;
use LLPM\WorkOrders\CalculateStorageCharges;
use LLPM\Containers\ContainerDaysCalculationByWorkOrder;
use WorkOrder;

class CalculateStorageChargesByWorkOrder		
{
	protected $calculateStorageCharges;
	protected $workOrderRepository;
	protected $containerDaysCalculationByWorkOrder;

	public function __construct(
		CalculateStorageCharges $calculateStorageCharges,
		WorkOrderRepository $workOrderRepository,
		ContainerDaysCalculationByWorkOrder $containerDaysCalculationByWorkOrder
	)
	{
		$this->calculateStorageCharges = $calculateStorageCharges;
		$this->workOrderRepository = $workOrderRepository;
		$this->containerDaysCalculationByWorkOrder = $containerDaysCalculationByWorkOrder;
	}

	public function fire($workorder)
	{
		// dd($workorder);
		$workorder = $this->checkInstance($workorder);

		//Should recalculate empty container days
		$this->containerDaysCalculationByWorkOrder->fire($workorder);
		
		$storageCharges = $this->calculateStorageCharges->fire($workorder);

		// dd($storageCharges);

		// Update workorder
		$this->updateWorkorder($workorder, $storageCharges);

		// Log::info('Storage Charges: ' . $storageCharges);
		Log::info('Storage Charges: ' . $storageCharges);

	}

	public function updateWorkorder($workorder, $storageCharges)
	{
		$workorder->storage_charges = $storageCharges;

		$workorder->save();
	}

	public function checkInstance($workorder)
	{
		if($workorder instanceOf WorkOrder) {
			return $workorder;
		}

		return $this->workOrderRepository->getById($workorder);
	}
}
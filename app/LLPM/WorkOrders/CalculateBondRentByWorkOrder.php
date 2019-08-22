<?php

namespace LLPM\WorkOrders;

use Illuminate\Support\Facades\Log;
use LLPM\Repositories\WorkOrderRepository;
use LLPM\WorkOrders\CalculateBondRent;
use LLPM\Containers\BondDaysCalculationByWorkOrder;
use WorkOrder;

class CalculateBondRentByWorkOrder		
{
	protected $calculateBondRent;
	protected $workOrderRepository;
	protected $bondDaysCalculationByWorkOrder;

	public function __construct(
		CalculateBondRent $calculateBondRent,
		WorkOrderRepository $workOrderRepository,
		BondDaysCalculationByWorkOrder $bondDaysCalculationByWorkOrder
	)
	{
		$this->calculateBondRent = $calculateBondRent;
		$this->workOrderRepository = $workOrderRepository;
		$this->bondDaysCalculationByWorkOrder = $bondDaysCalculationByWorkOrder;
	}

	public function fire($workorder)
	{
		// dd($workorder);
		$workorder = $this->checkInstance($workorder);

		//Should recalculate bond days
		$this->bondDaysCalculationByWorkOrder->fire($workorder);
		
		$bondRent = $this->calculateBondRent->fire($workorder);

		// dd($bondRent);

		// Update workorder
		$this->updateWorkorder($workorder, $bondRent);

		// Log::info('Storage Charges: ' . $storageCharges);
		Log::info('Bond Rent: ' . $bondRent);

	}

	public function updateWorkorder($workorder, $bondRent)
	{
		$workorder->bond_rent = $bondRent;

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
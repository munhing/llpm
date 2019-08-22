<?php

namespace LLPM\WorkOrders;

use Illuminate\Support\Facades\Log;
use LLPM\Repositories\ContainerConfirmationRepository;
use LLPM\WorkOrders\CalculateChargesByWorkOrder;

class DailyWorkOrderBondRentCalculation		
{
	protected $calculateHandlingCharges;
	protected $containerConfirmationRepository;
	protected $calculateChargesByWorkOrder;

	public function __construct(
		ContainerConfirmationRepository $containerConfirmationRepository,
		CalculateChargesByWorkOrder $calculateChargesByWorkOrder
	)
	{
		$this->containerConfirmationRepository = $containerConfirmationRepository;
		$this->calculateChargesByWorkOrder = $calculateChargesByWorkOrder;
	}

	public function fire()
	{
		$wo = [];
		$cc = $this->containerConfirmationRepository->getPendingHERO();
		foreach($cc as $c) {
			$wo[$c->workorder_id] = 1;
		}

		foreach($wo as $workorder_id => $not_important) {
			echo 'Recalculate WO#: ' . $workorder_id;
			$this->calculateChargesByWorkOrder->fire($workorder_id);
			echo '=>completed ' . "\n";
		}
		die();
	}


}
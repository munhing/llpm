<?php

namespace LLPM\WorkOrders;

use LLPM\Repositories\FeeRepository;

class CalculateStorageCharges		
{
	protected $feeRepository;
	protected $fees;
	protected $days_free = 5;

	public function __construct(FeeRepository $feeRepository)
	{
		
		$this->feeRepository = $feeRepository;
		// $this->fees = $this->getFees();
	}

	public function fire($workorder)
	{
		$charges = 0;

		$movement = explode('-', $workorder->movement);


		if(!($movement[0] == 'HE' || $movement[0] == 'RO')) {
			return 0;
		}

		// return 0 if there's no containers attached to the workorder
		if(count($workorder->containers) == 0) {
			return 0;
		}


		$this->fees = $this->getFees($workorder->date);


		foreach($workorder->containers as $container) {
			$charges += $this->getCharge($container);
			// dd($container->toArray());
		}

		return $charges;
	}

	public function getCharge($container)	
	{
		// storage fee is only applicable to empty storage
		// formula: [total_empty_days - 5_days] * [storage_fee]
		$days_empty = $container->days_empty;
		$container_size = $container->size;

		$days_chargeable = $days_empty - $this->days_free;

		if($days_chargeable <= 0) {
			return 0;
		}

		return $days_chargeable * $this->fees[$container_size];
	}

	public function getFees($carbonDate)
	{
		return json_decode($this->feeRepository->getStorageFeeByDate($carbonDate), true); // arg true is to convert to array instead of object
	}
}
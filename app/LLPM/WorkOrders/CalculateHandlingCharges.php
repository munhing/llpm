<?php

namespace LLPM\WorkOrders;

use LLPM\Repositories\FeeRepository;

class CalculateHandlingCharges		
{
	protected $feeRepository;
	protected $fees;

	public function __construct(FeeRepository $feeRepository)
	{
		
		$this->feeRepository = $feeRepository;
		// $this->fees = $this->getFees();
	}

	public function fire($workorder)
	{
		// dd($workorder->date);
		$charges = 0;

		// return 0 if there's no containers attached to the workorder
		if(count($workorder->containers) == 0) {
			return 0;
		}

		// get fees based on the workorder type and date
		$this->fees = $this->getFees($workorder);

		// dd($this->fees);
		foreach($workorder->containers as $container) {
			$charges += $this->getCharge($container);
		}

		return $charges;
	}

	public function getCharge($container)	
	{
		// get handling fees
		// $fees = $this->getFees();

		// the content should be based on the pivot table and not directly from the containers table

		$size = (string)$container->size;
		$sizeContent = $container->size . $container->pivot->content;

		// dd($size);
		if(isset($this->fees[$size])) {
			return $this->fees[$size];
			// dd($this->fees[$size]);
		} else {
			return $this->fees[$sizeContent];
			// dd($this->fees[$sizeContent]);
		}
	}

	public function getFees($workorder)
	{
		// $handlingType = $this->feeRepository->getHandlingType($workorder->movement);

		return json_decode($this->feeRepository->getHandlingFeeByDate($workorder->movement, $workorder->date), true); // arg true is to convert to array instead of object
	}
	
}
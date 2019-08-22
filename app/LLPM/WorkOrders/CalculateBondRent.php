<?php

namespace LLPM\WorkOrders;

// use LLPM\Repositories\FeeRepository;

class CalculateBondRent	
{
	// protected $feeRepository;
	protected $fees;
	protected $bondColumnName = 'days_bond_import';	//default column name
	protected $days_free = 3;

	public function __construct()
	{
		
		// $this->feeRepository = $feeRepository;
		// $this->fees = $this->getFees();
	}

	public function fire($workorder)
	{
		$charges = 0;

		$movement = explode('-', $workorder->movement);
		// $movement = $workorder->movement;

		// if workorder type not matched, return 0 because there is no charges
		if(!($movement[0] == 'RO' || $movement[0] == 'US' || $movement[0] == 'HE')) {
			return 0;
		}

		// if movement is haulage export, then change the column name
		if($movement[0] == 'HE') {
			$this->bondColumnName = 'days_bond_export';
		}

		// return 0 if there's no containers attached to the workorder
		if(count($workorder->containers) == 0) {
			return 0;
		}

		$this->fees = $this->getFees($workorder->date);

		foreach($workorder->containers as $container) {
			$charges += $this->getCharge($container);
		}

			// dd($charges);
		return $charges;
	}

	public function getFee($num_weeks)
	{
		if($num_weeks > 17) {
			return $this->fees[17];
		}

		return $this->fees[$num_weeks];
	}

	public function getFees($date)
	{
		$bond = [
			1 => 3,
			2 => 6,
			3 => 12,
			4 => 24,
			5 => 48,
			6 => 48,
			7 => 48,
			8 => 48,
			9 => 96,
			10 => 96,
			11 => 96,
			12 => 96,
			13 => 192,
			14 => 192,
			15 => 192,
			16 => 192,
			17 => 384
		];

		return $bond;
	}

	public function getCharge($container)	
	{
		// storage fee is only applicable to empty storage
		// formula: [total_empty_days - 5_days] * [storage_fee]
		$days_bond = $container->{$this->bondColumnName};
		// $container_size = $container->size;

		// dd($days_bond);
		// $days_chargeable = $days_empty - $this->days_free;

		if($days_bond <= $this->days_free) {
		// dd($days_bond);
			return 0;
		}

		// get number of weeks
		$num_weeks = $this->getWeeks($days_bond);

		// dd($num_weeks);
		// dd($this->getFee($num_weeks));
		// dd($this->getM3($container->size));

		return $num_weeks * $this->getFee($num_weeks) * $this->getM3($container->size);
	}

	public function getWeeks($days_bond)
	{
		$floor = floor($days_bond/7);
		if($days_bond % 7 == 0){
			return $floor;
		}

		return $floor + 1;
	}

	public function getM3($container_size)
	{
		if($container_size == 20) {
			return 25;
		}

		return 50;
	}

	// public function getFees($carbonDate)
	// {
	// 	return json_decode($this->feeRepository->getStorageFeeByDate($carbonDate), true); // arg true is to convert to array instead of object
	// }
}
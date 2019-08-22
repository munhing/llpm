<?php

namespace LLPM\Repositories;

use Fee;
use Carbon\Carbon;

class FeeRepository {

	public function save(Fee $fee)
	{
		return $fee->save();
	}

	// Get latest Handling fees
	public function getHandlingFee()
	{
		return Fee::where('type','handling')->orderBy('effective_date', 'desc')->first()->fee;
	}

	// Get latest Storage fees
	public function getStorageFee()
	{
		return Fee::where('type','storage')->orderBy('effective_date', 'desc')->first()->fee;
	}

	// Get all handling fees
	public function getHandlingFees($handlingType)
	{
		return Fee::where('type',$handlingType)->orderBy('effective_date', 'desc')->get();
	}

	// Get all haulage fees
	public function getHaulageFees()
	{
		return Fee::where('type','haulage')->orderBy('effective_date', 'desc')->get();
	}

	// Get all lifting fees
	public function getLiftingFees()
	{
		return Fee::where('type','lifting')->orderBy('effective_date', 'desc')->get();
	}

	// Get all activity fees
	public function getActivityFees()
	{
		return Fee::where('type','activity')->orderBy('effective_date', 'desc')->get();
	}

	// Get all transfer fees
	public function getTransferFees()
	{
		return Fee::where('type','transfer')->orderBy('effective_date', 'desc')->get();
	}

	// Get all storage fees
	public function getStorageFees()
	{
		return Fee::where('type','storage')->orderBy('effective_date', 'desc')->get();
	}	

	// Get correct Handling fees according to the workorder date
	// the Date must be a Carbon object
	public function getHandlingFeeByDate($movement, $carbonDate)
	{
		// dd($carbonDate);
		$handlingType = $this->getHandlingType($movement);
		$carbonDate = $this->checkCarbon($carbonDate);

		$fees = $this->getHandlingFees($handlingType);

		foreach($fees as $fee) {

			if($carbonDate >= $fee->effective_date) {
				// {"20E":, "20L":, "40E":, "40L":}
				return $fee->fee;
			}
		}		
	}

	// Get correct Storage fees according to the workorder date
	// the Date must be a Carbon object
	public function getStorageFeeByDate($carbonDate)
	{
		$carbonDate = $this->checkCarbon($carbonDate);

		$fees = $this->getStorageFees();

		foreach($fees as $fee) {

			if($carbonDate >= $fee->effective_date) {
				// {"20E":, "20L":, "40E":, "40L":}
				return $fee->fee;
			}
		}		
	}		

	public function checkCarbon($date)
	{
		if($date instanceof Carbon) {
			return $date;
		}

		return Carbon::parse($date);
	}

	public function getHandlingType($movement)
	{
		$movement = explode('-', $movement);

		$handlingType = [
			'HI' => 'haulage',
			'HE' => 'haulage',
			'RI' => 'lifting',
			'RO' => 'lifting',
			'ST' => 'activity',
			'US' => 'activity',
			'TF' => 'transfer',
			'EM' => 'activity',
			'VGM' => 'lifting'
		];

		return $handlingType[$movement[0]];
	}	
}
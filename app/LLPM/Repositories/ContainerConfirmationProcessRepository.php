<?php namespace LLPM\Repositories;

use ContainerConfirmationProcess;

class ContainerConfirmationProcessRepository {

	public function getProcess($movement)
	{
		return ContainerConfirmationProcess::where('movement', $movement)
				->first();
	}

	public function getAllProcesses()
	{
		return ContainerConfirmationProcess::all();
	}	
}
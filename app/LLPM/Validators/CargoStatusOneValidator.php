<?php namespace LLPM\Validators;

use Illuminate\Support\MessageBag;
use LLPM\Repositories\CargoRepository;

class CargoStatusOneValidator
{

	protected $cargoRepository;
	protected $error;

	public function __construct(MessageBag $error, CargoRepository $cargoRepository)
	{
		$this->cargoRepository = $cargoRepository;
		$this->error = $error;
	}

	public function validate($array)
	{

		$cargo = $this->cargoRepository->getById($array[1]->cargo_id);
		// dd($cargo->toArray());
		if($cargo->status != 1) {
			$this->error->add($cargo->bl_no, " already received!");
		}

		//dd($this->error->first());
	}

	public function passes()
	{
		return count($this->error) === 0;
	}

	public function fails()
	{
		return ! $this->passes();
	}

	public function getErrorMessage()
	{
		return $this->error;
	}	
}
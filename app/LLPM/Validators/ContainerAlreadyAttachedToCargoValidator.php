<?php namespace LLPM\Validators;

use Illuminate\Support\MessageBag;
use LLPM\Repositories\CargoRepository;

class ContainerAlreadyAttachedToCargoValidator
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
		// dd($array);
        if($array[0]->cargoes->contains($array[1]->cargo_id)) {
            $this->error->add($array[0]->container_no, $array[0]->container_no . " already attached this cargo!");
        }
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
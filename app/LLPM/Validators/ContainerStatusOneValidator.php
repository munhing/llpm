<?php namespace LLPM\Validators;

use Illuminate\Support\MessageBag;

class ContainerStatusOneValidator
{

	protected $error;

	public function __construct(MessageBag $error)
	{
		$this->error = $error;
	}

	// array container $ctn and $cargo_id
	public function validate($array)
	{
		// dd($array[0]->toArray());
		if($array[0]->status != 1) {
			$this->error->add($array[0]->container_no, $array[0]->container_no . " is already in the port!");
		}

		if($array[0]->status == 1 && $array[0]->current_movement != 0) {
			$this->error->add($array[0]->container_no, $array[0]->container_no . " already been issued Work Order " . $array[0]->current_movement);
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
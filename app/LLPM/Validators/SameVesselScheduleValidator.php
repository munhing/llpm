<?php namespace LLPM\Validators;

use Illuminate\Support\MessageBag;

class SameVesselScheduleValidator
{

	protected $error;	

	public function __construct(MessageBag $error)
	{
		$this->error = $error;
	}

	// $array consist of $container and $command
	public function validate($array)
	{
		//var_dump((int)$this->schedule_id);
		//var_dump($container->import_vessel_schedule_id);
		//dd($array[1]);

		if($array[0]->import_vessel_schedule_id != $array[1]->import_vessel_schedule_id) {
			$this->error->add($array[0]->container_no, $array[0]->container_no . " is not registered to this vessel!");
		}

		//dd(count($this->error));
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
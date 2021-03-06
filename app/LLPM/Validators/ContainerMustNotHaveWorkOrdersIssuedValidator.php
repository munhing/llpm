<?php

namespace LLPM\Validators;

use Illuminate\Support\MessageBag;

class ContainerMustNotHaveWorkOrdersIssuedValidator
{
	protected $error;

	public function __construct(MessageBag $error)
	{
		$this->error = $error;
	}


	public function validate($params)
	{
		// $param[0] is a Container object
		$container = $params[0];

		if(count($container->workorders) != 0) {
			$this->error->add($container->container_no, " has been issued workorder!");
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
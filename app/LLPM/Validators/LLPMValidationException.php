<?php namespace LLPM\Validators;

use Illuminate\Support\MessageBag;

class LLPMValidationException extends \Exception
{
	protected $errors;

	function __construct($message)
	{
		//$this->errors = $errors;

		parent::__construct($message);

	}

	public  function getErrors()
	{
		//$this->errors;
	}
}
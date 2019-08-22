<?php namespace LLPM\Validators;

use Illuminate\Support\MessageBag;

class LLPMValidator
{

	protected $validators;
	protected $errors;

	public function __construct($validators = [], MessageBag $errors)
	{
		$this->validators = $validators;
		$this->errors = $errors;
	}

	public function validate($params)
	{
		
		foreach($this->validators as $validator)
		{
			$validator->validate($params);

			if($validator->fails()) {
				//dd($validator->getErrorMessage());
				//$this->errors[] = $validator->getErrorMessage();
				$this->errors->merge($validator->getErrorMessage());
			}
		}
	}

	public function passes()
	{
		return count($this->errors) === 0;
	}

	public function fails()
	{
		return ! $this->passes();
	}

	public function getErrorMessages()
	{
		return $this->errors;
	}
}
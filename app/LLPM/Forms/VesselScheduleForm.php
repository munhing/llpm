<?php namespace LLPM\Forms;

use Laracasts\Validation\FormValidator;
use Laracasts\Validation\FormValidationException;

class VesselScheduleForm extends FormValidator{

	protected $rules = [
		'vessel_id' 		=> 'required',
		'voyage_no_arrival'	=> 'required',
		'portuser_id'		=> 'required',
		'eta' 				=> 'required',
		'etd' 				=> 'required',
	];

	protected $changeAttributes = [
		'vessel_id' 		=> 'Vessel',
		'voyage_no_arrival'	=> 'Voyage #',
		'portuser_id'		=> 'Agent',
		'eta' 				=> 'ETA',
		'etd' 				=> 'ETD',		
	];

	public function validate($formData)
	{
		$formData = $this->normalizeFormData($formData);

		$this->validation = $this->validator->make(
			$formData,
			$this->getValidationRules(),
			$this->getValidationMessages()
		);

		// Change the name of the fields when displaying errors
		$this->validation->setAttributeNames($this->getChangeAttributes());

		if ($this->validation->fails())
		{
			throw new FormValidationException('Validation failed', $this->getValidationErrors());
		}

		return true;
	}

	public function getChangeAttributes()
	{
		return $this->changeAttributes;
	}

}
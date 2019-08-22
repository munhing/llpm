<?php namespace LLPM\Forms;

use Laracasts\Validation\FormValidator;
use Laracasts\Validation\FormValidationException;

class ImportCargoForm extends FormValidator{

	protected $rules = [
		'bl_no' 	=> 'required|unique:cargoes,bl_no',
		'consignor_id'  => 'required',
		'consignee_id'  => 'required',
		'mt'  => 'required',
		'm3'  => 'required'
	];

	protected $changeAttributes = [];

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

    public function validateUpdate(array $input, $id, $vessel_schedule_id, $column_name)
    {
        $this->rules['bl_no'] .= ','.$id.',id,'. $column_name .','.$vessel_schedule_id;
        return $this->validate($input);
    }

    public function validateRegister(array $input, $vessel_schedule_id, $column_name)
    {
        $this->rules['bl_no'] .= ',NULL,id,'. $column_name.','.$vessel_schedule_id;
        return $this->validate($input);
    }

	public function getChangeAttributes()
	{
		return $this->changeAttributes;
	}
}
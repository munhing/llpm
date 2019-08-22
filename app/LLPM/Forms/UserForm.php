<?php 

namespace LLPM\Forms;

use Laracasts\Validation\FormValidator;
use Laracasts\Validation\FormValidationException;

class UserForm extends FormValidator{

	protected $rules = [
		'name' 		=> 'required',
		'email'		=> 'required|email|unique:users',
		'role' 		=> 'required',
		'username' 	=> 'required|unique:users',
		'password'	=> 'required|confirmed'
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

    public function validateUpdate(array $input)
    {
        $this->rules['email'] .= ',email,'.$input['user_id'];
        $this->rules['username'] .= ',username,'.$input['user_id'];
        $this->rules['password'] = '';

        return $this->validate($input);
    }

    public function validateUpdateProfile(array $input)
    {
        $this->rules['email'] .= ',email,'.$input['user_id'];
        $this->rules['username'] .= ',username,'.$input['user_id'];
        $this->rules['role'] = '';
        $this->rules['password'] = '';

        return $this->validate($input);
    }

    public function validateUpdatePassword(array $input)
    {
        $this->rules['name'] 	= '';
        $this->rules['email'] 	= '';
        $this->rules['role'] 	= '';
        $this->rules['username'] = '';

        return $this->validate($input);
    }

	public function getChangeAttributes()
	{
		return $this->changeAttributes;
	}
}
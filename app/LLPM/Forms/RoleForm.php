<?php namespace LLPM\Forms;

use Laracasts\Validation\FormValidator;

class RoleForm extends FormValidator{

	protected $rules = [
		'role' 			=> 'required|unique:roles',
		'description' 	=> 'required'
	];

}
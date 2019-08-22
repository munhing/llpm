<?php namespace LLPM\Forms;

use Laracasts\Validation\FormValidator;

class PortUserForm extends FormValidator{

	protected $rules = [
		'name' 	=> 'required|unique:port_users'
	];

}
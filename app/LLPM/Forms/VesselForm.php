<?php namespace LLPM\Forms;

use Laracasts\Validation\FormValidator;

class VesselForm extends FormValidator{

	protected $rules = [
		'name' 	=> 'required|unique:vessels'
	];

}
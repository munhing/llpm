<?php 

namespace LLPM\Forms;

use Laracasts\Validation\FormValidator;

class HandlingFeeForm extends FormValidator{

	protected $rules = [
		'e20'	=> 'required',
		'l20'	=> 'required',
		'e40' 	=> 'required',
		'l40' 	=> 'required',
		'handling_effective_date' 	=> 'required'
	];

}
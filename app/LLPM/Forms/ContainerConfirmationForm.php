<?php 

namespace LLPM\Forms;

use Laracasts\Validation\FormValidator;

class ContainerConfirmationForm extends FormValidator{

	protected $rules = [
		'a_confirmation'	=> 'required',
		'a_operator'		=> 'required',
		'a_date'		 	=> 'required',
		'a_confirmed_at' 	=> 'required'
	];

}
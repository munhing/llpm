<?php 

namespace LLPM\Forms;

use Laracasts\Validation\FormValidator;

class CargoItemForm extends FormValidator{

	protected $rules = [
		'custom_tariff_code'	=> 'required',
		'uoq'					=> 'required',
		'description' 			=> 'required',
		'quantity' 				=> 'required'
	];

}
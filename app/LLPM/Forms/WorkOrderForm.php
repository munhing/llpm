<?php 

namespace LLPM\Forms;

use Laracasts\Validation\FormValidator;

class WorkOrderForm extends FormValidator{

	protected $rules = [
		'type'			=> 'required',
		'handler_id'	=> 'required',
		'carrier_id' 	=> 'required',
		'containers' 	=> 'required'
	];

}
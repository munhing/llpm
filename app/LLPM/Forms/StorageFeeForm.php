<?php 

namespace LLPM\Forms;

use Laracasts\Validation\FormValidator;

class StorageFeeForm extends FormValidator{

	protected $rules = [
		's20'	=> 'required',
		's40' 	=> 'required',
		'storage_effective_date' 	=> 'required'
	];

}
<?php 

namespace LLPM\Forms;

use Laracasts\Validation\FormValidator;

class ContainerForm extends FormValidator{

	protected $rules = [
		'container_no'	=> 'required|alpha_num',
		'size'			=> 'required|integer'
	];

}
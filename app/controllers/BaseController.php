<?php

use Laracasts\Commander\CommanderTrait;
use LLPM\AccessTrait;

class BaseController extends Controller {

	use CommanderTrait;
	use AccessTrait;

	public $access = [];

	function __construct()
	{
		$this->access = $this->getAccess();
	}		
	
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}

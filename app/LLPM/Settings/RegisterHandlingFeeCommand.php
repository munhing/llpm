<?php

namespace LLPM\Settings;

class RegisterHandlingFeeCommand {

	public $handling_effective_date;

	public $l40;

	public $e40;

	public $l20;

	public $e20;
    /**
     */
    public function __construct($e20, $l20, $e40, $l40, $handling_effective_date)
    {
    	$this->e20 = $e20;
		$this->l20 = $l20;
		$this->e40 = $e40;
		$this->l40 = $l40;
		$this->handling_effective_date = $handling_effective_date;
    }

}
<?php

namespace LLPM\Settings;

class RegisterStorageFeeCommand {

	public $storage_effective_date;

	public $s40;

	public $s20;
    /**
     */
    public function __construct($s20, $s40, $storage_effective_date)
    {
    	$this->s20 = $s20;
		$this->s40 = $s40;
		$this->storage_effective_date = $storage_effective_date;
    }

}
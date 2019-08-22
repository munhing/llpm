<?php

namespace LLPM\Settings;

class UpdateStorageFeeCommand {

	public $storage_effective_date;

	public $s40;

	public $s20;

	public $storage_fee_id;
    /**
     */
    public function __construct($storage_fee_id, $s20, $s40, $storage_effective_date)
    {
    	$this->storage_fee_id = $storage_fee_id;
    	$this->s20 = $s20;
		$this->s40 = $s40;
		$this->storage_effective_date = $storage_effective_date;
    }

}
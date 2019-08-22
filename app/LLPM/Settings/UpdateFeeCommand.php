<?php

namespace LLPM\Settings;

class UpdateFeeCommand {

	public $fee_id;

	public $effective_date1;

	public $effective_date2;

	public $fee_type;

	public $l40;

	public $e40;

	public $l20;

	public $e20;

	public $s20;

	public $s40;
    /**
     */
    public function __construct($fee_id, $e20=0, $l20=0, $e40=0, $l40=0, $s20=0, $s40=0, $fee_type, $effective_date1='', $effective_date2='')
    {
    	$this->fee_id = $fee_id;
    	$this->e20 = $e20;
		$this->l20 = $l20;
		$this->e40 = $e40;
		$this->l40 = $l40;
		$this->s20 = $s20;
		$this->s40 = $s40;
		$this->fee_type = $fee_type;
		$this->effective_date1 = $effective_date1;
		$this->effective_date2 = $effective_date2;
    }

}
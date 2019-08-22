<?php 
namespace LLPM\Confirmation;

class ConfirmContainerCommand {

	public $a_confirmation;
	public $a_carrier;
	public $a_lifter;
    public $a_date;
	public $a_confirmed_at;
    public $a_operator;
	public $a_cp;
    public $bypass;

    /**
     */
    public function __construct(
    	$a_confirmation, 
    	$a_carrier, 
    	$a_lifter, 
        $a_date = '', 
    	$a_confirmed_at = '', 
    	$a_operator = 0,
        $a_cp,
        $bypass
    )
    {
		$this->a_confirmation = $a_confirmation;
		$this->a_carrier = $a_carrier;
		$this->a_lifter = $a_lifter;
        $this->a_date = $a_date;
		$this->a_confirmed_at = $a_confirmed_at;
        $this->a_operator = $a_operator;
		$this->a_cp = $a_cp;
        $this->bypass = $bypass;
    }

}
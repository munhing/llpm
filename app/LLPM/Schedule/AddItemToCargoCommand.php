<?php 

namespace LLPM\Schedule;

class AddItemToCargoCommand {

    
	public $custom_tariff_code;
	public $description;
	public $quantity;
	public $cargo_id;
    public $uoq;

    public function __construct($custom_tariff_code, $description, $quantity, $cargo_id, $uoq)
    {
    	$this->custom_tariff_code = $custom_tariff_code;
    	$this->description = $description;
    	$this->quantity = $quantity;
    	$this->cargo_id = $cargo_id;
        $this->uoq = $uoq;
    }

}
<?php

namespace LLPM\Schedule;

class UpdateCargoItemCommand {

	public $cargo_item_id;
	public $custom_tariff_code;
	public $uoq;
	public $description;
	public $quantity;


    public function __construct($cargo_item_id, $custom_tariff_code, $uoq, $description, $quantity)
    {
		$this->cargo_item_id = $cargo_item_id;
		$this->custom_tariff_code = $custom_tariff_code;
		$this->uoq = $uoq;
		$this->description = $description;
		$this->quantity = $quantity;
    }

}
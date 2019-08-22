<?php namespace LLPM\Receiving;

class UpdateCargoItemCommand {

	public $cargo_item_id;

	public $custom_tariff_code;

	public $description;

	public $quantity;


    /**
     */
    public function __construct($cargo_item_id, $custom_tariff_code, $description, $quantity)
    {

		$this->cargo_item_id = $cargo_item_id;

		$this->custom_tariff_code = $custom_tariff_code;

		$this->description = $description;

		$this->quantity = $quantity;
    }

}
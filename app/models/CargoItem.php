<?php

use Laracasts\Commander\Events\EventGenerator;
// use LLPM\Schedule\Events\ImportCargoWasRegistered;
// use LLPM\Schedule\Events\ImportCargoWasUpdated;

class CargoItem extends \Eloquent {

	use EventGenerator;

	protected $table = "cargo_items";

	protected $fillable = ['cargo_id', 'custom_tariff_code', 'description', 'quantity'];

	public function cargo()
	{
		return $this->belongsTo('Cargo', 'cargo_id');
	}		

	public function customTariff()
	{
		return $this->belongsTo('CustomTariff', 'custom_tariff_code', 'code');
	}	

	public static function register($cargo_id, $custom_tariff_code, $description, $quantity)
	{
		$cargoItem = new static(compact('cargo_id', 'custom_tariff_code', 'description', 'quantity'));

		//$importCargo->raise(new ImportCargoWasRegistered($importCargo));

		return $cargoItem;
	}	

	public static function edit($cargo_item_id, $custom_tariff_code, $description, $quantity)
	{
		$cargoItem = static::find($cargo_item_id);

		$cargoItem->custom_tariff_code = $custom_tariff_code;
		$cargoItem->description = $description;
		$cargoItem->quantity = $quantity;

		return $cargoItem;
	}
}
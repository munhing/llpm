<?php

use Laracasts\Commander\Events\EventGenerator;
// use LLPM\Schedule\Events\ImportCargoWasRegistered;
// use LLPM\Schedule\Events\ImportCargoWasUpdated;

class CustomTariff extends \Eloquent {

	use EventGenerator;

	protected $table = "custom_tariff";

	protected $fillable = ['code', 'description', 'uoq', 'group'];

	public function cargoItems()
	{
		return $this->hasMany('CargoItem', 'custom_tariff_code', 'code');
	}		

}
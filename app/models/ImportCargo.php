<?php

use Laracasts\Commander\Events\EventGenerator;
use LLPM\Schedule\Events\ImportCargoWasRegistered;
use LLPM\Schedule\Events\ImportCargoWasUpdated;

class ImportCargo extends \Eloquent {

	use EventGenerator;

	protected $table = "cargoes";

	protected $fillable = ['bl_no', 'vessel_schedule_id', 'consignor_id', 'consignee_id', 'mt', 'm3', 'description', 'markings', 'custom_reg_no', 'country_code', 'port_code', 'custom_form_no', 'dl_no'];

	public function schedule()
	{
		return $this->belongsToMany('VesselSchedule', 'cargo_schedule', 'cargo_id', 'vessel_schedule_id');
	}		

	public function portUser()
	{
		return $this->belongsTo('PortUser', 'portuser_id');
	}

	public function consignor()
	{
		return $this->belongsTo('PortUser', 'consignor_id');
	}

	public function consignee()
	{
		return $this->belongsTo('PortUser', 'consignee_id');
	}

	public function importContainers()
	{
		return $this->belongsToMany('ImportContainer', 'cargo_container', 'cargo_id', 'container_id');
	}

	public static function register($bl_no, $vessel_schedule_id, $consignor_id, $consignee_id, $mt, $m3, $description, $markings)
	{
		$importCargo = new static(compact('bl_no', 'vessel_schedule_id', 'consignor_id', 'consignee_id', 'mt', 'm3', 'description', 'markings'));

		$importCargo->raise(new ImportCargoWasRegistered($importCargo));

		return $importCargo;
	}	

	public static function edit($id, $bl_no, $vessel_schedule_id, $consignor_id, $consignee_id, $mt, $m3, $description, $markings, $country_code, $port_code, $custom_reg_no, $custom_form_no)
	{
		$importCargo = static::find($id);

		$importCargo->bl_no = $bl_no;
		$importCargo->vessel_schedule_id = $vessel_schedule_id;
		$importCargo->consignor_id = $consignor_id;
		$importCargo->consignee_id = $consignee_id;
		$importCargo->mt = $mt; 
		$importCargo->m3 = $m3; 
		$importCargo->description = $description;
		$importCargo->markings = $markings;
		$importCargo->country_code = $country_code;
		$importCargo->port_code = $port_code;
		$importCargo->custom_reg_no = $custom_reg_no;
		$importCargo->custom_form_no = $custom_form_no;

		$importCargo->raise(new ImportCargoWasUpdated($importCargo));

		return $importCargo;
	}

	public static function issue($id, $dl_no)
	{
		$importCargo = static::find($id);

		$importCargo->dl_no = $dl_no;

		return $importCargo;
	}

}
<?php

use Laracasts\Commander\Events\EventGenerator;
// use LLPM\Schedule\Events\ImportCargoWasRegistered;
// use LLPM\Schedule\Events\ImportCargoWasUpdated;
use Carbon\Carbon;

class Cargo extends \Eloquent {

	use EventGenerator;

	protected $table = "cargoes";

	protected $dates = array('received_date', 'issued_date', 'released_date');

	protected $fillable = ['bl_no', 'consignor_id', 'consignee_id', 'mt', 'm3', 'status', 'description', 'markings', 'containerized', 'custom_reg_no', 'country_code', 'port_code', 'custom_form_no', 'dl_no', 'import_vessel_schedule_id', 'export_vessel_schedule_id', 'receiving_id', 'received_by', 'received_date', 'issued_by', 'issued_date', 'released_by', 'released_date'];

	public function importSchedule()
	{
		return $this->belongsTo('VesselSchedule', 'import_vessel_schedule_id');
	}		

	public function exportSchedule()
	{
		return $this->belongsTo('VesselSchedule', 'export_vessel_schedule_id');
	}	

	public function receiving()
	{
		return $this->belongsTo('Receiving', 'receiving_id');
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

	public function containers()
	{
		return $this->belongsToMany('Container', 'cargo_container', 'cargo_id', 'container_id')->withTimestamps();
	}

	public function cargoItems()
	{
		return $this->hasMany('CargoItem');
	}

	public function m_containers()
	{
		return $this->belongsToMany('Container', 'm_cargo_container', 'cargo_id', 'container_id')->withTimestamps();
	}

	public static function register($bl_no, $consignor_id, $consignee_id, $mt, $m3, $status, $description, $markings, $import_vessel_schedule_id, $receiving_id)
	{
		$importCargo = new static(compact('bl_no', 'consignor_id', 'consignee_id', 'mt', 'm3', 'status', 'description', 'markings', 'import_vessel_schedule_id', 'receiving_id'));

		//$importCargo->raise(new ImportCargoWasRegistered($importCargo));

		return $importCargo;
	}	

    public function getVesselScheduleImportAttribute()
    {
    	if(is_null($this->importSchedule)) {
    		return '';
    	}

        return $this->importSchedule->vessel->name . " V." . $this->importSchedule->voyage_no_arrival;
    }

    public function getVesselScheduleExportAttribute()
    {
    	if(is_null($this->exportSchedule)) {
    		return '';
    	}

        return $this->exportSchedule->vessel->name . " V." . $this->exportSchedule->voyage_no_departure;
    }

    public function getVesselScheduleEtaAttribute()
    {
    	if(is_null($this->exportSchedule)) {
    		return '';
    	}

        return $this->exportSchedule->eta;
    }

    public function getVesselScheduleEtdAttribute()
    {
    	if(is_null($this->exportSchedule)) {
    		return '';
    	}

        return $this->exportSchedule->etd;
    }    

    public function getConsigneeNameAttribute()
    {
    	if(is_null($this->consignee)) {
    		return '';
    	}

        return $this->consignee->name;
    }

    public function getShipperNameAttribute()
    {
    	if(is_null($this->consignor)) {
    		return '';
    	}

        return $this->consignor->name;
    }

	public static function registerExport($bl_no, $consignor_id, $consignee_id, $mt, $m3, $status, $description, $markings, $export_vessel_schedule_id, $receiving_id)
	{
		$exportCargo = new static(compact('bl_no', 'consignor_id', 'consignee_id', 'mt', 'm3', 'status', 'description', 'markings', 'export_vessel_schedule_id', 'receiving_id'));

		//$importCargo->raise(new ImportCargoWasRegistered($importCargo));

		return $exportCargo;
	}

	public static function edit($id, $bl_no, $consignor_id, $consignee_id, $mt, $m3, $description, $markings, $country_code, $port_code, $custom_reg_no, $custom_form_no, $import_vessel_schedule_id, $receiving_id)
	{
		$importCargo = static::find($id);

		$importCargo->bl_no = $bl_no;
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
        $importCargo->import_vessel_schedule_id;
        $importCargo->receiving_id;

		//$importCargo->raise(new ImportCargoWasUpdated($importCargo));

		return $importCargo;
	}

	public static function editExport($id, $bl_no, $consignor_id, $consignee_id, $mt, $m3, $description, $markings, $country_code, $port_code, $custom_reg_no, $custom_form_no)
	{
		$exportCargo = static::find($id);

		$exportCargo->bl_no = $bl_no;
		$exportCargo->consignor_id = $consignor_id;
		$exportCargo->consignee_id = $consignee_id;
		$exportCargo->mt = $mt; 
		$exportCargo->m3 = $m3; 
		$exportCargo->description = $description;
		$exportCargo->markings = $markings;
		$exportCargo->country_code = $country_code;
		$exportCargo->port_code = $port_code;
		$exportCargo->custom_reg_no = $custom_reg_no;
		$exportCargo->custom_form_no = $custom_form_no;
		//$exportCargo->raise(new exportCargoWasUpdated($exportCargo));

		return $exportCargo;
	}

	public static function issue($id, $dl_no)
	{
		$importCargo = static::find($id);

		$importCargo->dl_no = $dl_no;
		$importCargo->issued_date = Carbon::now();

		return $importCargo;
	}	

}
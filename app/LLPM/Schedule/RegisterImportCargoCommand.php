<?php namespace LLPM\Schedule;

class RegisterImportCargoCommand {

	public $bl_no;

	public $consignor_id;

	public $consignee_id;

	public $mt;

	public $m3;

	public $description;

	public $markings;

	public $import_vessel_schedule_id;

	public $receiving_id;	

	//public $containers;	
    /**
     */
    public function __construct($bl_no, $consignor_id, $consignee_id, $mt, $m3, $description, $markings, $import_vessel_schedule_id, $receiving_id)
    {

		$this->bl_no = $bl_no;

		$this->consignor_id = $consignor_id;

		$this->consignee_id = $consignee_id;

		$this->mt = $mt;

		$this->m3 = $m3;

		$this->description = $description;

		$this->markings = $markings;

    	$this->import_vessel_schedule_id = $import_vessel_schedule_id;

    	$this->receiving_id = $receiving_id;	

    	//$this->containers = $containers;	

    }

}
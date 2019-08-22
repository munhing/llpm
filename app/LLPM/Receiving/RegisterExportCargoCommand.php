<?php namespace LLPM\Receiving;

class RegisterExportCargoCommand {

	public $bl_no;

	public $consignor_id;

	public $consignee_id;

	public $mt;

	public $m3;

	public $description;

	public $markings;

	public $export_vessel_schedule_id;

	public $receiving_id;

    /**
     */
    public function __construct($bl_no, $consignor_id, $consignee_id, $mt, $m3, $description, $markings, $export_vessel_schedule_id, $receiving_id)
    {

		$this->bl_no = $bl_no;

		$this->consignor_id = $consignor_id;

		$this->consignee_id = $consignee_id;

		$this->mt = $mt;

		$this->m3 = $m3;

		$this->description = $description;

		$this->markings = $markings;

		$this->export_vessel_schedule_id = $export_vessel_schedule_id;		

		$this->receiving_id = $receiving_id;
    }

}
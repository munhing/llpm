<?php namespace LLPM\Schedule;

class UpdateExportCargoCommand {

	public $cargo_id;

	public $bl_no;

	public $consignor_id;

	public $consignee_id;

	public $mt;

	public $m3;

	public $description;

	public $markings;

	public $country_code;

	public $port_code;

	public $custom_reg_no;

	public $custom_form_no;

    /**
     */
    public function __construct($cargo_id, $bl_no, $consignor_id, $consignee_id, $mt, $m3, $description, $markings, $country_code, $port_code, $custom_reg_no, $custom_form_no)
    {

		$this->cargo_id = $cargo_id;

		$this->bl_no = $bl_no;

		$this->consignor_id = $consignor_id;

		$this->consignee_id = $consignee_id;

		$this->mt = $mt;

		$this->m3 = $m3;

		$this->description = $description;

		$this->markings = $markings;

		$this->country_code = $country_code;

		$this->port_code = $port_code;

		$this->custom_reg_no = $custom_reg_no;

		$this->custom_form_no = $custom_form_no;	

    	//$this->containers = $containers;			

    }

}
<?php namespace LLPM\Schedule;

class IssueImportCargoCommand {

	public $vessel_schedule_id;

	public $cargo_id;

    /**
     */
    public function __construct($vessel_schedule_id, $cargo_id)
    {

		$this->vessel_schedule_id = $vessel_schedule_id;

		$this->cargo_id = $cargo_id;

    }

}
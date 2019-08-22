<?php namespace LLPM\Receiving;

class IssueExportCargoCommand {

	public $receiving_id;

	public $cargo_id;

    /**
     */
    public function __construct($receiving_id, $cargo_id)
    {

		$this->receiving_id = $receiving_id;

		$this->cargo_id = $cargo_id;

    }

}
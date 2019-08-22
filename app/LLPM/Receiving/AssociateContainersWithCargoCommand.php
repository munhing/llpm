<?php namespace LLPM\Receiving;

class AssociateContainersWithCargoCommand {

    
	public $containers;
	public $receiving_id;
	public $cargo_id;

    public function __construct($containers, $receiving_id, $cargo_id)
    {
    	$this->containers = $containers;
    	$this->receiving_id = $receiving_id;
    	$this->cargo_id = $cargo_id;
    }

}
<?php

namespace LLPM\Schedule;

class DeleteCargoCommand {

    
	public $cargo_id;

    public function __construct($cargo_id)
    {
    	$this->cargo_id = $cargo_id;
    }

}
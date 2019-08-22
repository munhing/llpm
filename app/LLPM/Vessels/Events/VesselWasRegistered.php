<?php namespace LLPM\Vessels\Events;

use Vessel;

class VesselWasRegistered {

    public $vessel;

    public function __construct(Vessel $vessel) /* or pass in just the relevant fields */
    {
        $this->vessel = $vessel;
    }

}
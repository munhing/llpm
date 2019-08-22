<?php namespace LLPM\Schedule\Events;

use VesselSchedule;

class VesselScheduleWasRegistered {

    public $vesselSchedule;

    public function __construct(VesselSchedule $vesselSchedule) /* or pass in just the relevant fields */
    {
        $this->vesselSchedule = $vesselSchedule;
    }

}
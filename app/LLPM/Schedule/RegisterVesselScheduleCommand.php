<?php namespace LLPM\Schedule;

class RegisterVesselScheduleCommand {

    public $vessel_id;
    public $voyage_no_arrival;
    public $portuser_id;
    public $eta;
    public $etd;

    public function __construct($vessel_id, $voyage_no_arrival, $portuser_id, $eta, $etd)
    {
        $this->vessel_id = $vessel_id;
        $this->voyage_no_arrival = $voyage_no_arrival;
        $this->portuser_id = $portuser_id;
        $this->eta = $eta;
        // $this->eta = convertToMySQLDate($eta);
        $this->etd = $etd;
        // $this->etd = convertToMySQLDate($etd);
    }

}
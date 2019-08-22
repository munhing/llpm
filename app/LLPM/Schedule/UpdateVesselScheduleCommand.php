<?php namespace LLPM\Schedule;

class UpdateVesselScheduleCommand {

	public $schedule_id;
    public $vessel_id;
    public $portuser_id;
    public $voyage_no_arrival;
    public $voyage_no_departure;
    public $eta;
    public $etd;
    public $mt_arrival;
    public $mt_departure;    
    public $m3_arrival;
    public $m3_departure; 

    public function __construct($schedule_id, $vessel_id, $portuser_id, $voyage_no_arrival, $voyage_no_departure, $eta, $etd, $mt_arrival, $mt_departure, $m3_arrival, $m3_departure)
    {
        $this->schedule_id = $schedule_id;
        $this->vessel_id = $vessel_id;
        $this->portuser_id = $portuser_id;
        $this->voyage_no_arrival = $voyage_no_arrival;
        $this->voyage_no_departure = $voyage_no_departure;
        $this->eta = $eta;
        // $this->eta = convertToMySQLDate($eta);
        $this->etd = $etd;
        // $this->etd = convertToMySQLDate($etd);
        $this->mt_arrival = $mt_arrival;
        $this->mt_departure = $mt_departure;
        $this->m3_arrival = $m3_arrival;
        $this->m3_departure = $m3_departure;
    }

}
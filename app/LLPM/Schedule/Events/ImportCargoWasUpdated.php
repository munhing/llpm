<?php namespace LLPM\Schedule\Events;

use ImportCargo;

class ImportCargoWasUpdated {

    public $importCargo;

    public function __construct(ImportCargo $importCargo) /* or pass in just the relevant fields */
    {
        $this->importCargo = $importCargo;
    }

}
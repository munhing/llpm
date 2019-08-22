<?php namespace LLPM\Schedule\Events;

use ImportCargo;

class ImportCargoWasRegistered {

    public $importCargo;

    public function __construct(ImportCargo $importCargo) /* or pass in just the relevant fields */
    {
        $this->importCargo = $importCargo;
    }

}
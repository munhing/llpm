<?php namespace LLPM\Schedule\Events;

use ImportContainer;

class ImportContainerWasRegistered {

    public $importContainer;

    public function __construct(ImportContainer $importContainer) /* or pass in just the relevant fields */
    {
        $this->importContainer = $importContainer;
    }

}
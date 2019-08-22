<?php namespace LLPM\PortUser\Events;

use PortUser;

class PortUserWasRegistered {

    public $portUser;

    public function __construct(PortUser $portUser) /* or pass in just the relevant fields */
    {
        $this->portUser = $portUser;
    }

}
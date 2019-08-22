<?php namespace LLPM\Users\Events;

use Role;

class RoleWasRegistered {

    public $role;

    public function __construct(Role $role) /* or pass in just the relevant fields */
    {
        $this->role = $role;
    }

}
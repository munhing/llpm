<?php

namespace LLPM\Users;

class RegisterRoleCommand {

    /**
     * @var string
     */
    public $role;
    public $description;

    /**
     * @param string role
     */
    public function __construct($role, $description)
    {
        $this->role = $role;
        $this->description = $description;
    }

}
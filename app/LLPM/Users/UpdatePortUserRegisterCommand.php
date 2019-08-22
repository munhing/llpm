<?php

namespace LLPM\Users;

class UpdatePortUserRegisterCommand {

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */

    public $name;

    public $company;

    public $user_id;

    /**
     * @param string username
     * @param string email
     * @param string password
     */
    public function __construct($username, $email, $name, $company, $user_id)
    {
        $this->username = $username;
        $this->email = $email;
        $this->name = $name;
        $this->company = $company;
        $this->user_id = $user_id;
    }

}
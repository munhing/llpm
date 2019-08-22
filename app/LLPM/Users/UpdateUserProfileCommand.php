<?php

namespace LLPM\Users;

class UpdateUserProfileCommand {

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


    public $user_id;

    /**
     * @param string username
     * @param string email
     * @param string password
     */
    public function __construct($username, $email, $name, $user_id)
    {
        $this->username = $username;
        $this->email = $email;
        $this->name = $name;
        $this->user_id = $user_id;
    }

}
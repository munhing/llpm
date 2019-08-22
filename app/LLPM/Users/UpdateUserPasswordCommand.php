<?php

namespace LLPM\Users;

class UpdateUserPasswordCommand {

    /**
     * @var string
     */
    public $password_user_id;
    public $password;

    /**
     * @param string password
     */
    public function __construct($password_user_id, $password)
    {
        $this->password_user_id = $password_user_id;
        $this->password = $password;
    }

}
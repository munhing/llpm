<?php namespace LLPM\Users;

class RegisterUserCommand {

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
    public $password;

    public $name;

    public $role;

    /**
     * @param string username
     * @param string email
     * @param string password
     */
    public function __construct($username, $email, $password, $name, $role)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->role = $role;
    }

}
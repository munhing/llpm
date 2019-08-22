<?php namespace LLPM\Users;

class RegisterPortUserRegisterCommand {

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

    public $company;

    /**
     * @param string username
     * @param string email
     * @param string password
     */
    public function __construct($username, $email, $password, $name, $company)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->company = $company;
    }

}
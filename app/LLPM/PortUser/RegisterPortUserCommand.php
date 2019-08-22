<?php namespace LLPM\PortUser;

class RegisterPortUserCommand {

	public $name;
    /**
     */
    public function __construct($name)
    {
    	$this->name = $name;
    }

}
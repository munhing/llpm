<?php namespace LLPM\Vessels;

class RegisterVesselCommand {

    /**
     * @var string
     */
    public $name;

    /**
     * @param string name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

}
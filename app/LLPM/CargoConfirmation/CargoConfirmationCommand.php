<?php namespace LLPM\CargoConfirmation;

class CargoConfirmationCommand {

	public $confirmationId;

    /**
     */
    public function __construct(array $confirmationId)
    {
		$this->confirmationId = $confirmationId;
    }

}
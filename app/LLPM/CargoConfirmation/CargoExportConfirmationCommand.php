<?php namespace LLPM\CargoConfirmation;

class CargoExportConfirmationCommand {

	public $confirmationId;

    /**
     */
    public function __construct(array $confirmationId)
    {
		$this->confirmationId = $confirmationId;
    }

}
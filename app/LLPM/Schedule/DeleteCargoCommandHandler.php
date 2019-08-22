<?php

namespace LLPM\Schedule;

use LLPM\Repositories\CargoRepository;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class DeleteCargoCommandHandler implements CommandHandler {

	use DispatchableTrait;

    protected $containerRepository;
    protected $messages;
	protected $app;
    private $cargoRepository;

	function __construct(
        CargoRepository $cargoRepository
    )
	{
        $this->cargoRepository = $cargoRepository;
	}

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {

        $cargo = $this->cargoRepository->getById($command->cargo_id);

        // dd($cargo->cargoItems->toArray());

        if(count($cargo->cargoItems) != 0) {
            return false;
        }

        $cargo->delete();

        return $cargo;
    }
}
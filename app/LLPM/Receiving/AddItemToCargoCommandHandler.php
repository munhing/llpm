<?php namespace LLPM\Receiving;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\CargoItemRepository;

use CargoItem;
use Illuminate\Support\MessageBag;
use Illuminate\Foundation\Application;
//use Exception;

class AddItemToCargoCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $cargoItemRepository;
    protected $messages;
    protected $app;

	function __construct(CargoItemRepository $cargoItemRepository, MessageBag $messages, Application $app)
	{
        $this->cargoItemRepository = $cargoItemRepository;
        $this->messages = $messages;
        $this->app = $app;
	}

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {

        //dd($command);

        //create new cargo item
        $cargoItem = CargoItem::register(
            $command->cargo_id,
            $command->custom_tariff_code,
            $command->description,
            $command->quantity
        );

        $cargoItem = $this->cargoItemRepository->save($cargoItem);

    }

}
<?php namespace LLPM\Receiving;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\CommanderTrait;

use LLPM\Repositories\CargoItemRepository;
use CargoItem;


class UpdateCargoItemCommandHandler implements CommandHandler {

	use DispatchableTrait;
	use CommanderTrait;

	protected $cargoItemRepository;

	function __construct(CargoItemRepository $cargoItemRepository)
	{
		$this->cargoItemRepository = $cargoItemRepository;
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

		$cargoItem = CargoItem::edit(
			$command->cargo_item_id,
			$command->custom_tariff_code,
			$command->description, 
			$command->quantity
		);

		$this->cargoItemRepository->save($cargoItem);

		return $cargoItem;  	
    }

}
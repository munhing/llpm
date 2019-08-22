<?php 

namespace LLPM\Schedule;

use CargoItem;
use CustomTariff;
use LLPM\Repositories\CargoItemRepository;
use LLPM\Repositories\CustomTariffRepository;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
//use Exception;

class AddItemToCargoCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $cargoItemRepository;
    protected $customTariffRepository;

	function __construct(
        CargoItemRepository $cargoItemRepository, 
        CustomTariffRepository $customTariffRepository
    )
	{
        $this->cargoItemRepository = $cargoItemRepository;
        $this->customTariffRepository = $customTariffRepository;
	}

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {

        // dd($command);

        // Save tariff code and uoq if not listed
        $this->validateTariffCode($command);

        //create new cargo item
        $cargoItem = CargoItem::register(
            $command->cargo_id,
            $command->custom_tariff_code,
            $command->description,
            $command->quantity
        );

        $cargoItem = $this->cargoItemRepository->save($cargoItem);

    }

    public function validateTariffCode($command)
    {
        if($tariff = $this->customTariffRepository->getByCode($command->custom_tariff_code)) {
            return true;
        }

        CustomTariff::create(array(
            'code' => $command->custom_tariff_code,
            'uoq' => $command->uoq
        ));  
    }

}
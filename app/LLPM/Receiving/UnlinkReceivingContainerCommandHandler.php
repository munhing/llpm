<?php namespace LLPM\Receiving;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\CargoRepository;
use LLPM\Repositories\ReceivingRepository;
use Container;

class UnlinkReceivingContainerCommandHandler implements CommandHandler {

	use DispatchableTrait;

    protected $containerRepository;
	protected $cargoRepository;
    protected $receivingRepository;

	protected $registeredContainers = [];

	function __construct(ContainerRepository $containerRepository, CargoRepository $cargoRepository, ReceivingRepository $receivingRepository)
	{
        $this->containerRepository = $containerRepository;
		$this->cargoRepository = $cargoRepository;
        $this->receivingRepository = $receivingRepository;
	}

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {
        $container = $this->containerRepository->getById($command->container_id);
        $cargo = $this->cargoRepository->getById($command->cargo_id);

        // detach container from cargo
        $container->cargoes()->detach($command->cargo_id);

        // need to reload again to reflect on the changes to the number of cargo after the detach
        $container = $this->containerRepository->getById($command->container_id);

        if(count($container->cargoes) == 0)
        {
             //Container content becomes E
            $container->content = 'E';
            $container->dl_check = 0;
            $container->save();
        }

        // cargo.containerize decrease by 1
        $cargo->decrement('containerized');

		return $container;    	
    }


}
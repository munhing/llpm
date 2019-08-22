<?php namespace LLPM\Receiving;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\CargoRepository;

use LLPM\Receiving\RegisterReceivingContainersCommandHandler;

use Container;
use Cargo;
use Illuminate\Support\MessageBag;
use Illuminate\Foundation\Application;

class AssociateContainersWithCargoCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $containerRepository;
    protected $cargoRepository;

    protected $messages;
	protected $registeredContainers = [];
    protected $app;
    protected $registerContainer;

	function __construct(ContainerRepository $containerRepository, CargoRepository $cargoRepository, MessageBag $messages, Application $app, RegisterReceivingContainersCommandHandler $registerContainer)
	{
		$this->containerRepository = $containerRepository;
        $this->cargoRepository = $cargoRepository;
        $this->messages = $messages;
        $this->app = $app;
        $this->registerContainer = $registerContainer;
	}

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {
        $this->registerContainer->handle($command);
        // Loop through each container object
        foreach($command->containers as $container) {

            //Check if the container already existed
            if($ctn = $this->containerExist($container->container_no)) {

                if($this->validateContainer($ctn)) {

                    $ctn = $this->updateContainer($ctn, $command->cargo_id);

                    $this->registeredContainers[] = $ctn;
                }
            }
		}

        // attached each container to cargo
        $this->associateContainersWithCargo($this->registeredContainers, $command->cargo_id);

        $this->incrementContainerizedCargo($command->cargo_id, count($this->registeredContainers));
    }

    public function containerExist($containerNo)
    {
        if (count($ctn = $this->containerRepository->getActiveByContainerNo($containerNo)) > 0) {
            return $ctn;
        }

        return false;
    }

    public function updateContainer($container, $cargo_id)
    {
        // update container content to Laden
        
        
        $container->content = 'L';
        $container->dl_check = 1;

        // check if cargo already issued DL, if yes, dl_check = 0
        if($this->hasIssuedDL($cargo_id)) {
            $container->dl_check = 0;
        }

        $container->save();

        return $container;
    }

    public function associateContainersWithCargo($containers, $cargo_id)
    {
        foreach($containers as $container) {

            $ctn = $this->containerRepository->getById($container->id);

            if(! $ctn->cargoes->contains($cargo_id)) {
                $ctn->cargoes()->attach($cargo_id);
            }

        }
    }

    public function validateContainer($container)
    {
        if($container->status == 2 && $container->current_movement == 0)
        {
            return true;
        }

        return false;
    }

    public function incrementContainerizedCargo($cargo_id, $count)
    {
        $this->cargoRepository->containerizedIncrement($cargo_id, $count);        
    }  

    public function hasIssuedDL($cargo_id)
    {
        $cargo = $this->cargoRepository->getById($cargo_id);

        if($cargo->dl_no != 0) {
            return true;
        }

        return false;      
    }       
}
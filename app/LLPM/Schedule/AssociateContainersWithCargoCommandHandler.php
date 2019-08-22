<?php

namespace LLPM\Schedule;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\CargoRepository;

use LLPM\Schedule\RegisterImportContainersCommandHandler;

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

	function __construct(
        ContainerRepository $containerRepository, 
        CargoRepository $cargoRepository, 
        MessageBag $messages, 
        Application $app, 
        RegisterImportContainersCommandHandler $registerContainer
    )
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
        // dd($command);
        // Pass the $command-containers to RegisterImportContainersCommandHandler
        $this->registerContainer->handle($command);

        // Loop through each container object
        foreach($command->containers as $container) {

            $validator = $this->app->make('AssociateContainerValidator');

            if($ctn = $this->containerExist($container->container_no)) {

                $validator->validate([$ctn, $command]);

                if($validator->passes()) {

                    $ctn = $this->updateContainer($ctn);
                    
                    $this->registeredContainers[] = $ctn;

                    $this->messages->add($ctn->container_no, "$ctn->container_no was registered successfully!");

                } else {

                    $this->messages->merge($validator->getErrorMessages());
                    
                }
            }
		}

        // attached each container to cargo
        $this->associateContainersWithCargo($this->registeredContainers, $command->cargo_id);

        $this->incrementContainerizedCargo($command->cargo_id, count($this->registeredContainers));

		return $this->messages;
    }

    public function containerExist($containerNo)
    {
        if (count($ctn = $this->containerRepository->getActiveByContainerNo($containerNo)) > 0) {
            return $ctn;
        }

        return false;
    }

    public function updateContainer($container)
    {
        // update container content to Laden
        $container->content = 'L';
        $container->dl_check = 1;
        $container->m_content = 'L';
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

            if(! $ctn->m_cargoes->contains($cargo_id)) {
                $ctn->m_cargoes()->attach($cargo_id);
            }
        }
    }

    public function incrementContainerizedCargo($cargo_id, $count)
    {
        $this->cargoRepository->containerizedIncrement($cargo_id, $count);        
    }
}
<?php namespace LLPM\Schedule;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\ContainerRepository;
use Container;

class RegisterImportContainersCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $containerRepository;
	protected $registeredContainers = [];

	function __construct(ContainerRepository $containerRepository)
	{
		$this->containerRepository = $containerRepository;
	}

    /**
     * Register new empty containers through Incoming Vessel
     *
     * @param object $command
     * @return array of Container class, $registeredContainers
     */
    public function handle($command)
    {  
    	foreach($command->containers as $container) {

            //validate container is not already listed
            if($this->containerExist($container->container_no)) {
                continue;
            }

            // register new container
            $container = $this->registerContainer($container, $command);

            // append register container to array container
			$this->registeredContainers[] = $container;
		}

		return $this->registeredContainers;    	
    }

    /**
     * Check for active containers with the same container no
     *
     * @param string $containerNo
     * @return bool
     */
    public function containerExist($containerNo)
    {
    	return (count($this->containerRepository->getActiveByContainerNo($containerNo)) > 0);
    }

    /**
     * Register the container
     *
     * @param stdClass object $container
     * @param integer $receiving_id
     * @return Container $container
     */
    public function registerContainer($container, $command)
    {
        $importContainer = Container::register(
            $container->container_no,
            $container->size,
            $container->content,
            $container->status,
            0,
            $container->content,
            $command->import_vessel_schedule_id
        );

        return $this->containerRepository->save($importContainer);
    }
}
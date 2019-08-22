<?php namespace LLPM\Receiving;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\ReceivingRepository;
use Container;

class RegisterReceivingContainersCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $containerRepository;
    protected $receivingRepository;

	protected $registeredContainers = [];

	function __construct(ContainerRepository $containerRepository, ReceivingRepository $receivingRepository)
	{
		$this->containerRepository = $containerRepository;
        $this->receivingRepository = $receivingRepository;
	}

    /**
     * Register new empty containers through Receiving
     *
     * @param object $command
     * @return array of Container class, $registeredContainers
     */
    public function handle($command)
    {
        // generate receiving id;
        $receiving = $this->receivingRepository->generateReceivingId();

    	foreach($command->containers as $container) {

            // validate container is not already listed
            if($this->containerExist($container->container_no)) {
                // skip to next foreach item
                continue;
            }

            // register new container
            $container = $this->registerContainer($container, $receiving->id);

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
    public function registerContainer($container, $receiving_id)
    {
        $container = Container::registerReceiving(
            $container->container_no,
            $container->size,
            $container->content,
            $container->status,
            0,
            $receiving_id
        );

        return $this->containerRepository->save($container);
    }
}
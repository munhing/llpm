<?php 

namespace LLPM\Schedule;

use Container;
use Activity;
use LLPM\Repositories\ContainerRepository;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\DispatchableTrait;


class UpdateContainerCommandHandler implements CommandHandler {

	use DispatchableTrait;
	use CommanderTrait;

	protected $containerRepository;

	function __construct(ContainerRepository $containerRepository)
	{
		$this->containerRepository = $containerRepository;
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

		$container = Container::editBasic(
			$command->container_id,
			$command->container_no,
			$command->size
		);

		$this->containerRepository->save($container);

        Activity::log('Container Id: ' . $container->id . ' was updated from ' . $command->container_no_old . ':' . $command->size_old . ' to ' . $container->container_no . ':' . $container->size);

		return $container;  	
    }

}
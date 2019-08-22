<?php

namespace LLPM\Schedule;

use Illuminate\Support\MessageBag;
use Illuminate\Foundation\Application;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\ContainerRepository;

class DeleteImportContainerCommandHandler implements CommandHandler {

	use DispatchableTrait;

    protected $containerRepository;
    protected $messages;
	protected $app;

	function __construct(
        ContainerRepository $containerRepository,
        MessageBag $messages, 
        Application $app
    )
	{
		$this->containerRepository = $containerRepository;
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
        $validator = $this->app->make('DeleteContainerValidator');

        $container = $this->containerRepository->getById($command->container_id);

        // should validate first before delete
        // the rules is
        // 1. container should not have any workorder
        // 2. container must not be laden
        $validator->validate([$container]);

        if($validator->passes()) {
            $container->delete();
        }

		return $container;   	
    }


}
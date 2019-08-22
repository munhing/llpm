<?php namespace LLPM\Schedule;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\CargoRepository;

use Container;
use Illuminate\Support\MessageBag;
use Illuminate\Foundation\Application;

class DetachContainerFromCargoCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $containerRepository;
    protected $cargoRepository;

    protected $messages;
    protected $app;

	function __construct(ContainerRepository $containerRepository, CargoRepository $cargoRepository, MessageBag $messages, Application $app)
	{
		$this->containerRepository = $containerRepository;
        $this->cargoRepository = $cargoRepository;
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

        // dd($command);

        $validator = $this->app->make('DetachContainerValidator');

        $ctn = $this->containerRepository->getById($command->container_id);

        $validator->validate([$ctn, $command]);

        if($validator->passes()) {

            // detach container
            $this->detachContainerFromCargo($ctn, $command->cargo_id);

            $this->updateContainerContent($ctn->id);

            $this->cargoRepository->containerizedDecrement($command->cargo_id, 1);

            $this->messages->add($ctn->container_no, "$ctn->container_no was removed successfully!");

        } else {

            $this->messages->merge($validator->getErrorMessages());
        }

		return $this->messages;
    }

    public function detachContainerFromCargo($container, $cargo_id)
    {
        $container->cargoes()->detach($cargo_id);
        $container->m_cargoes()->detach($cargo_id);
    }

    public function updateContainerContent($container_id)
    {
        $container = $this->containerRepository->getById($container_id);

        if(count($container->m_cargoes) === 0) {

            $container->content = 'E';
            $container->dl_check = 0;
            $container->m_content = 'E';
            $container->save();
        }
    }
}
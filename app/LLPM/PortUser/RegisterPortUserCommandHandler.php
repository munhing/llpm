<?php namespace LLPM\PortUser;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\PortUserRepository;
use PortUser;

class RegisterPortUserCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $portUserRepository;

	function __construct(PortUserRepository $portUserRepository)
	{
		$this->portUserRepository = $portUserRepository;
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
		$portUser = PortUser::register(
			$command->name
		);

		$this->portUserRepository->save($portUser);

		$this->dispatchEventsFor($portUser);

		return $portUser;    	
    }

}
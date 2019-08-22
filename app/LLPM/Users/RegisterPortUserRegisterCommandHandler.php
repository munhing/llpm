<?php namespace LLPM\Users;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\UserRepository;
use User;


class RegisterPortUserRegisterCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $userRepository;

	function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
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

		$user = User::registerPortUser(
			$command->name, 
			$command->username,
			$command->email,
			$command->company,
			$command->password
		);

		$this->userRepository->save($user);

		$this->dispatchEventsFor($user);

		return $user;
    }

}
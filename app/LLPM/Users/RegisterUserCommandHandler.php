<?php namespace LLPM\Users;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\UserRepository;
use User;


class RegisterUserCommandHandler implements CommandHandler {

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

		$user = User::register(
			$command->name, 
			$command->username, 
			$command->email, 
			$command->password,
                        1
		);

		$this->userRepository->save($user);

		$user->roles()->attach($command->role);

		$this->dispatchEventsFor($user);

		return $user;
    }

}

<?php 

namespace LLPM\Users;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\UserRepository;
use User;


class UpdatePortUserRegisterCommandHandler implements CommandHandler {

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

		$user = User::editPortUser(
			$command->user_id,
			$command->name, 
			$command->username, 
            $command->email,
			$command->company
		);

		$this->userRepository->save($user);

		return $user;
    }

}
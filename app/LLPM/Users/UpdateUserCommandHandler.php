<?php 

namespace LLPM\Users;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\UserRepository;
use User;


class UpdateUserCommandHandler implements CommandHandler {

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

		$user = User::edit(
			$command->user_id, 
			$command->name, 
			$command->username, 
			$command->email
		);

		$this->userRepository->save($user);

		$this->assignRole($user, $command);

		return $user;
    }

    public function assignRole($user, $command)
    {
    	$roles = $user->roles;

    	if($roles->contains($command->role))
    	{
    		return;
    	}

    	// detach all roles that belongs to the user
		$user->roles()->detach();

    	$user->roles()->attach($command->role);
    }

}
<?php namespace LLPM\Users;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\RoleRepository;
use Role;

class RegisterRoleCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $roleRepository;

	function __construct(RoleRepository $roleRepository)
	{
		$this->roleRepository = $roleRepository;
	}

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {

		$role = Role::register(
			$command->role,
			$command->description
		);

		$this->roleRepository->save($role);

		$this->dispatchEventsFor($role);

		return $role;
    }

}
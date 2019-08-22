<?php

use LLPM\Forms\PortUserRegisterForm;
use LLPM\Forms\RoleForm;
use LLPM\Forms\UserForm;
use LLPM\Repositories\PermissionRepository;
use LLPM\Repositories\RoleRepository;
use LLPM\Repositories\UserRepository;
use LLPM\Users\RegisterRoleCommand;
use LLPM\Users\RegisterUserCommand;
use LLPM\Users\RegisterPortUserRegisterCommand;
use LLPM\Users\UpdateUserCommand;
use LLPM\Users\UpdatePortUserRegisterCommand;
use LLPM\Users\UpdateUserPasswordCommand;
use LLPM\Users\UpdateUserProfileCommand;

class UsersController extends \BaseController {

	private $userForm;
	private $roleForm;	
	private $userRepository;
	private $roleRepository;
	private $permissionRepository;
	private $portUserRegisterForm;

	function __construct(
		UserForm $userForm, 
		RoleForm $roleForm, 
		UserRepository $userRepository, 
		RoleRepository $roleRepository, 
		PermissionRepository $permissionRepository,
		PortUserRegisterForm $portUserRegisterForm
	)
	{
		parent::__construct();
		$this->userForm = $userForm;
		$this->roleForm = $roleForm;		
		$this->userRepository = $userRepository;
		$this->roleRepository = $roleRepository;
		$this->permissionRepository = $permissionRepository;
		$this->portUserRegisterForm = $portUserRegisterForm;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = $this->userRepository->getAllStaff();
		$roles = $this->roleRepository->getAll();
		// dd($users->toArray());
		return View::make('users/index', compact('users', 'roles'))->withAccess($this->access);
	}

	public function indexPortUser()
	{
		$portusers = $this->userRepository->getAllPortUsers();
		// $roles = $this->roleRepository->getAll();
		// dd($users->toArray());
		return View::make('users/index_portuser', compact('portusers'))->withAccess($this->access);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//dd('register');
		$roles = $this->roleRepository->getAll();
		// dd($roles->toArray());
		return View::make('users/create', compact('roles'))->withAccess($this->access);
	}


	/**
	 * Secret Registration form
	 *
	 * @return Response
	 */
	public function secretRegister()
	{
		//dd('register');
		return View::make('users/secret_register')->withAccess($this->access);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->userForm->validate(Input::all());

		$user = $this->execute(RegisterUserCommand::class);

		Flash::success("User $user->username has been registered!");

		return Redirect::route('users');
	}

	public function storePortUserRegister()
	{
		// dd(Input::all());

		$this->portUserRegisterForm->validate(Input::all());

		$user = $this->execute(RegisterPortUserRegisterCommand::class);

		Flash::success("Thank you for registering with us. We will email you once your registration is approved.");

		return Redirect::back();
	}

	public function update()
	{
		$input = Input::all();

		$this->userForm->validateUpdate($input);
		// dd($input);

		$user = $this->execute(UpdateUserCommand::class);

		Flash::success("User $user->username has been updated!");

		return Redirect::back();		
	}

	public function updatePortUserRegister()
	{
		$input = Input::all();

		$this->portUserRegisterForm->validateUpdate($input);
		// dd($input);

		$user = $this->execute(UpdatePortUserRegisterCommand::class);

		Flash::success("Port User $user->username has been updated!");

		return Redirect::back();		
	}

	public function updateProfile()
	{
		$input = Input::all();

		$this->userForm->validateUpdateProfile($input);

		$user = $this->execute(UpdateUserProfileCommand::class);

		Flash::success("User $user->username has been updated!");

		return Redirect::back();		
	}

	public function updatePassword()
	{
		$input = Input::all();
		
		$this->userForm->validateUpdatePassword($input);

		$user = $this->execute(UpdateUserPasswordCommand::class);

		Flash::success("Password changed for User $user->username!");

		return Redirect::back();		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function indexRole()
	{
		$roles = $this->roleRepository->getAll();
		return View::make('users/index_role', compact('roles'))->withAccess($this->access);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function createRole()
	{
		//dd('register');
		return View::make('users/create_role');
	}


	public function storeRole()
	{
		$this->roleForm->validate(Input::all());

		$role = $this->execute(RegisterRoleCommand::class);

		Flash::success("Role $role->role has been registered!");

		return Redirect::route('roles');
	}

	public function rolePermissions($role_id)
	{
		// dd($role_id);
		$role = $this->roleRepository->getById($role_id);
		$permissions = $this->permissionRepository->getAll();
		return View::make('users/role_permission', compact('role', 'permissions'))->withAccess($this->access);
	}

	public function rolePermissionsUpdate($role_id)
	{
		$input = Input::all();
		$input['role_id'] = $role_id;
		// dd($input);
		$this->roleRepository->updatePermission($input['role_id'], $input['permit_id']);

		Flash::success("Access updated!");

		return Redirect::back();		
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function indexPermission()
	{

		$permissions = $this->permissionRepository->getAll();
		return View::make('users/index_permission', compact('permissions'))->withAccess($this->access);
	}

	public function getUsersByRole()
	{
		$role = Input::get('cp');

		if($role == 'MG') {
			$role = 'PB';
		}

		$users = $this->roleRepository->getByRole($role)->users;

		return $users->toJson();
	}

	public function checkAuth()
	{
		$input = Input::all();

		if(Hash::check($input['auth_password'], Auth::user()->password))
		{
			// return true
			return 1;
		}

		// return false
		return 0;
	}	

	public function profile()
	{
		// dd('My Profile');
		return View::make('users/profile')->withAccess($this->access);
	}

	public function approvePortUser()
	{
		$input = Input::all();

		// dd($input);

		$portuser = $this->userRepository->approvePortUser($input['portuser_id']);

		Flash::success("Port User ". $portuser->name . " has been approved!");

		return Redirect::back();		
	}	

	public function disablePortUser()
	{
		$input = Input::all();

		// dd($input);

		$portuser = $this->userRepository->disablePortUser($input['portuser_id']);

		Flash::success("Port User ". $portuser->name . " has been disabled!");

		return Redirect::back();		
	}	

	public function enablePortUser()
	{
		$input = Input::all();

		// dd($input);

		$portuser = $this->userRepository->enablePortUser($input['portuser_id']);

		Flash::success("Port User ". $portuser->name . " has been enabled!");

		return Redirect::back();		
	}
}

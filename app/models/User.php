<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Laracasts\Commander\Events\EventGenerator;
use LLPM\Users\Events\UserWasRegistered;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, EventGenerator;

	protected $fillable = ['username', 'name', 'email', 'password', 'company', 'is_staff'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function roles()
	{
		return $this->belongsToMany('Role');
	}

	public function permissions()
    {
        return $this->hasManyThrough('Permission', 'Role');
    }

	public function setPasswordAttribute($password)
	{
		$this->attributes['password'] = Hash::make($password);
	}

	public static function register($name, $username, $email, $password, $is_staff)
	{
		$user = new static(compact('name', 'username', 'email', 'password', 'is_staff'));

		$user->raise(new UserWasRegistered($user));

		return $user;

	}	

	public static function registerPortUser($name, $username, $email, $company, $password)
	{
		$user = new static(compact('name', 'username', 'email', 'company','password'));

		$user->raise(new UserWasRegistered($user));

		return $user;

	}

	public static function edit($id, $name, $username, $email)
	{
		$user = static::find($id);

		$user->name = $name;
		$user->username = $username;
		$user->email = $email;

		return $user;

	}

	public static function editPortUser($id, $name, $username, $email, $company)
	{
		$user = static::find($id);

		$user->name = $name;
		$user->username = $username;
		$user->email = $email;
		$user->company = $company;

		return $user;

	}

	public static function editPassword($id, $password)
	{
		$user = static::find($id);

		$user->password = $password;

		return $user;

	}
}

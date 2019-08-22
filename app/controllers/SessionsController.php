<?php

use LLPM\Forms\SignInForm;

class SessionsController extends \BaseController {

	protected $signInForm;

	function __construct(SignInForm $signInForm)
	{
		$this->signInForm = $signInForm;
		$this->beforeFilter('guest', ['except' => 'destroy']);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	public function checkAuth()
	{
		$input = Input::all();

		return "hello";

		if(Hash::check($input['auth_password'], Auth::user()->password))
		{
			// return true
			return 1;
		}

		// return false
		return 0;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function login()
	{
		return View::make('sessions/login2');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function reset()
	{
		return View::make('sessions/reset');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::only('username', 'password');
		$this->signInForm->validate($input);

		//dd($input);

		if ($status = Auth::attempt($input))
		{

			Flash::success('Welcome Back');
			//dd($status);
			return Redirect::intended('/');
		}

		return Redirect::back();

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		Auth::logout();
		Flash::message('Goodbye!');
		return Redirect::route('login');
	}


}

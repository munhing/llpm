<?php

class PublicAuthController extends \BaseController {

	public function checkAuth()
	{
		$input = Input::all();

		// return "hello";

		if(Hash::check($input['auth_password'], Auth::user()->password))
		{
			// return true
			return 1;
		}

		// return false
		return 0;
	}
}

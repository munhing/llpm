@extends('layouts/default_login2')

@section('content')

	

	@include('layouts/partials/errors')	

	{{ Form::open(['route' => 'login', 'class'=>'form-signin']) }}

		<h2 class="form-signin-heading">Please Login</h2>
	
		{{ Form::label('username', 'Username', ['class' => 'control-label visible-ie8 visible-ie9 sr-only']) }}
		{{ Form::text('username', null, ['class' => 'form-control placeholder-no-fix', 'placeholder' => 'Username']) }}


		{{ Form::label('password', 'Password', ['class' => 'control-label visible-ie8 visible-ie9 sr-only']) }}
		{{ Form::password('password', ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Password']) }}


		<div class="checkbox">
			<label>
				<input type="checkbox" name="remember" value="1"> Remember me
			</label>
		</div>
		<button type="submit" class="btn btn-lg btn-primary btn-block">
			Login
		</button>


		<div class="forget-password">
			<h4>Forgot your password ?</h4>
			<p>
				no worries, click <a href="{{ URL::to('password/remind') }}">
				here </a>
				to reset your password.
			</p>
		</div>

	{{ Form::close() }}

@stop
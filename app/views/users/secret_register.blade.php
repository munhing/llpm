@extends('layouts/default_login')

@section('content')

	<h3>Sign Up</h3>
	
	@include('layouts/partials/errors')

	{{ Form::open() }}

		<div class="form-group">

			{{ Form::label('username', 'Username', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			<div class="input-icon">
				<i class="fa fa-user"></i>
				{{ Form::text('username', null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Username']) }}
			</div>
		</div>
		<div class="form-group">

			{{ Form::label('name', 'Name', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			<div class="input-icon">
				<i class="fa fa-user"></i>
				{{ Form::text('name', null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Name']) }}
			</div>
		</div>
		<div class="form-group">

			{{ Form::label('role', 'Role', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			<div class="input-icon">
				<i class="fa fa-user"></i>
				{{ Form::text('role', null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Role']) }}
			</div>
		</div>			
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			{{ Form::label('email', 'Email', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				{{ Form::text('email', null, ['class' => 'form-control placeholder-no-fix', 'placeholder' => 'Email']) }}
			</div>
		</div>		
		<div class="form-group">
			{{ Form::label('password', 'Password', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				{{ Form::password('password', ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Password']) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('password_confirmation', 'Re-type Your Password', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			<div class="controls">
				<div class="input-icon">
					<i class="fa fa-check"></i>
					{{ Form::password('password_confirmation', ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Re-type Your Password']) }}
				</div>
			</div>
		</div>

		<div class="form-actions">

			<button type="submit" id="register-submit-btn" class="btn blue">
			Sign Up <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>

	{{ Form::close() }}

@stop
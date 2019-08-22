@extends('layouts/default_login2')

@section('content')

	<h3>Reset Your Password</h3>

	{{ Form::open() }}

		{{ Form::hidden('token', $token) }}

		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			{{ Form::label('email', 'Email', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				{{ Form::email('email', null, ['class' => 'form-control placeholder-no-fix', 'placeholder' => 'Email', 'required']) }}
			</div>
		</div>		
		<div class="form-group">
			{{ Form::label('password', 'Password', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				{{ Form::password('password', ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Password', 'required']) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('password_confirmation', 'Re-type Your Password', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			<div class="controls">
				<div class="input-icon">
					<i class="fa fa-check"></i>
					{{ Form::password('password_confirmation', ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Re-type Your Password', 'required']) }}
				</div>
			</div>
		</div>

		<div class="form-actions">

			<button type="submit" id="register-submit-btn" class="btn btn-primary">
			Reset <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>

	{{ Form::close() }}

@stop
@extends('layouts/default')

@section('content')

	<h3 class="page-title">
		Register New User <small>form</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('users') }}">Users</a>
				<i class="fa fa-angle-right"></i>
			</li>			
			<li>
				Register
			</li>
		</ul>
	</div>	

	{{ Form::open(['id' => 'form_user']) }}
		<div class="form-group">
			{{ Form::label('name', 'Name', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			{{ Form::text('name', null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Name']) }}
		</div>

		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			{{ Form::label('email', 'Email', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			{{ Form::text('email', null, ['class' => 'form-control placeholder-no-fix', 'placeholder' => 'Email']) }}
		</div>		

		<div class="form-group">
			{{ Form::label('role', 'Role', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			{{ Form::select('role', [null => "Please assign a role..."] + $roles->lists('description', 'id'), null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Role']) }}
		</div>
		
		<div class="form-group">
			{{ Form::label('username', 'Username', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			{{ Form::text('username', null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Username']) }}
		</div>

		<div class="form-group">
			{{ Form::label('password', 'Password', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			{{ Form::password('password', ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Password']) }}
		</div>
		<div class="form-group">
			{{ Form::label('password_confirmation', 'Re-type Your Password', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			{{ Form::password('password_confirmation', ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Re-type Your Password']) }}
		</div>

		<div class="form-actions">

			<button type="submit" id="register-submit-btn" class="btn blue" data-confirm>
			Sign Up <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>

	{{ Form::close() }}

@stop
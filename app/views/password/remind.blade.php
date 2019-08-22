@extends('layouts/default_login2')

@section('content')

	
	
	{{ Form::open(['class'=>'form-signin']) }}

		<h3>Forget Password ?</h3>

		<p>
			 Enter your e-mail address below to reset your password.
		</p>
		<div class="form-group">
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				{{ Form::text('email', null, ['class' => 'form-control placeholder-no-fix', 'placeholder' => 'Email', 'required' => 'required']) }}
			</div>
		</div>
		<div class="form-actions">

			<a href="{{ URL::route('login') }}" class="btn btn-default"><i class="m-icon-swapleft"></i> Back </a>
			<button type="submit" class="btn btn-primary pull-right">
			Submit <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>

	{{ Form::close() }}
	

@stop
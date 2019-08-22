@extends('layouts/default')

@section('content')

	<h3 class="page-title">
		Register New Vessel <small>form</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('users') }}">Vessels</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Register
			</li>					
		</ul>
	</div>	

	{{ Form::open(['id' => 'form_vessel']) }}

		<div class="form-group">

			{{ Form::label('name', 'Name', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			<div class="input-icon">
				<i class="fa fa-anchor"></i>
				{{ Form::text('name', null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Vessel Name']) }}
			</div>
		</div>

		<div class="form-actions">

			<button type="submit" id="register-submit-btn" class="btn blue" data-confirm>
			Register <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>

	{{ Form::close() }}

@stop
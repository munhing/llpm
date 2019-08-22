@extends('layouts/default')

@section('page_level_styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>
@stop
@section('content')

	<h3 class="page-title">
		Register Port User <small>form</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('portusers') }}">Port Users</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Register
			</li>					
		</ul>
	</div>	

	{{ Form::open() }}

		<div class="form-group">
			{{ Form::label('name', 'Name/Company', ['class' => 'control-label visible-ie8 visible-ie9']) }}
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-male"></i></span>
				{{ Form::text('name', null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Name/Company']) }}
			</div>
		</div>

		<div class="form-actions">
			<button type="submit" id="register-submit-btn" class="btn blue" data-confirm>
			Register <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>

	{{ Form::close() }}

@stop

@section('page_level_plugins')
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-pickers.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-dropdowns.js') }}"></script>
@stop

@section('scripts')
ComponentsPickers.init();
ComponentsDropdowns.init();
@stop


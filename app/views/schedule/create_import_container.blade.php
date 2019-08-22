@extends('layouts/default')

@section('page_level_styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>
@stop
@section('content')

	<h3 class="page-title">
		Register Empty Containers <small>form</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('manifest.schedule') }}">Schedule</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ route('manifest.schedule.import', $schedule->id ) }}"> {{ $schedule->vessel->name}} v.{{ $schedule->voyage_no_arrival }}</a>
				<i class="fa fa-angle-right"></i>
			</li>			
			<li>
				Register Empty Containers
			</li>					
		</ul>
	</div>	

	{{ Form::open(['id' => 'form_containers']) }}

	<div class="row">
		<div class="col-md-8 ">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-grid"></i>Empty Containers
					</div>
				</div>
				<div class="portlet-body">
					<div class="form-group">
						{{ Form::label('containers', 'Containers (eg. PCIU1112223-20, TCIU4443332-40)', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
							{{ Form::textarea('containers', null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Containers', 'rows' => '3']) }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6 ">
			<div class="form-actions">
				<button type="submit" id="register-submit-btn" class="btn blue" data-confirm>
				Register <i class="m-icon-swapright m-icon-white"></i>
				</button>
			</div>
		</div>
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


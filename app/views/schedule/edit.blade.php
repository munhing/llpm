@extends('layouts/default')

@section('page_level_styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
@stop
@section('content')

	<h3 class="page-title">
		Vessel Calling <small>form</small>
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
				Edit
			</li>					
		</ul>
	</div>	

	{{ Form::open(['id' => 'form_schedule_edit']) }}
		{{ Form::hidden('schedule_id', $vesselSchedule->id) }}
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					{{ Form::label('vessel_id', 'Vessel', ['class' => 'control-label']) }}
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-anchor"></i></span>
						{{ Form::text('vessel_id', $vesselSchedule->vessel->id, ['class' => 'form-control']) }}
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					{{ Form::label('portuser_id', 'Agent', ['class' => 'control-label']) }}
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						{{ Form::text('portuser_id', $vesselSchedule->portUser->id, ['class' => 'form-control']) }}
					</div>
				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="portlet box blue-hoki">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-anchor"></i>Import
						</div>
					</div>
					<div class="portlet-body">

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('voyage_no_arrival', 'Voyage No', ['class' => 'control-label']) }}
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-compass"></i></span>
										{{ Form::text('voyage_no_arrival', $vesselSchedule->voyage_no_arrival, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Voyage No']) }}
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('eta', 'ETA', ['class' => 'control-label']) }}
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										{{ Form::text('eta', $vesselSchedule->eta->format('Y-m-d'), ['class' => 'form-control form-control-inline input-medium date-picker', 'placeholder' => 'ETA']) }}
									</div>
								</div>
							</div>	
						</div>	

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('mt_arrival', 'MT', ['class' => 'control-label']) }}
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-compass"></i></span>
										{{ Form::text('mt_arrival', $vesselSchedule->mt_arrival, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'MT']) }}
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('m3_arrival', 'M3', ['class' => 'control-label']) }}
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-compass"></i></span>
										{{ Form::text('m3_arrival', $vesselSchedule->m3_arrival, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'M3']) }}
									</div>
								</div>
							</div>
						</div>																
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="portlet box blue-hoki">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-anchor"></i>Export
						</div>
					</div>
					<div class="portlet-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('voyage_no_departure', 'Voyage No', ['class' => 'control-label']) }}
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-compass"></i></span>
										{{ Form::text('voyage_no_departure', $vesselSchedule->voyage_no_departure, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Voyage No']) }}
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('etd', 'ETD', ['class' => 'control-label']) }}
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										{{ Form::text('etd', $vesselSchedule->etd->format('Y-m-d'), ['class' => 'form-control form-control-inline input-medium date-picker', 'placeholder' => 'ETD']) }}
									</div>
								</div>
							</div>	
						</div>	

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('mt_departure', 'MT', ['class' => 'control-label']) }}
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-compass"></i></span>
										{{ Form::text('mt_departure', $vesselSchedule->mt_departure, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'MT']) }}
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('m3_departure', 'M3', ['class' => 'control-label']) }}
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-compass"></i></span>
										{{ Form::text('m3_departure', $vesselSchedule->m3_departure, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'M3']) }}
									</div>
								</div>
							</div>

						</div>												
					</div>
				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="form-actions">
					<button id="register-btn" class="btn blue" data-confirm="Are you sure?">
					Update <i class="m-icon-swapright m-icon-white"></i>
					</button>
				</div>
			</div>
		</div>
	{{ Form::close() }}

@stop

@section('page_level_plugins')
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/app/bootstrap-datepicker-1.4.0-dist/js/bootstrap-datepicker.min.js') }}"></script>
@stop

@section('scripts')

	$('.date-picker').datepicker({
	    format: "yyyy-mm-dd",
	    todayBtn: "linked",
	    autoclose: true,
	    todayHighlight: true
	});

	$(".date-picker").datepicker().on('show.bs.modal', function(event) {
	    // prevent datepicker from firing bootstrap modal "show.bs.modal"
	    event.stopPropagation(); 
	});

	select2Plugin('#vessel_id', "{{route('manifest.vessels.list')}}", "{{$vesselSchedule->vessel->name}}", "Please select a vessel");
	select2Plugin('#portuser_id', "{{route('workorders.handler_list')}}", "{{$vesselSchedule->portUser->name}}", "Please select an agent");

@stop


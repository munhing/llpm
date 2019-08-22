@extends('layouts/default')

@section('page_level_styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>
@stop
@section('content')

	<h3 class="page-title">
		{{ $cargo->bl_no }} <small>edit</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('receiving.show', $cargo->receiving_id) }}">Receiving</a>
				<i class="fa fa-angle-right"></i>
			</li>			
			<li>
				<a href="{{ URL::route('receiving.cargo.show', [$cargo->receiving_id, $cargo->id]) }}">{{ $cargo->bl_no }}</a>
				<i class="fa fa-angle-right"></i>
			</li>				
			<li>
				Edit
			</li>						
		</ul>
	</div>	

	{{ Form::open(['route'=>['receiving.cargo.edit', $cargo->receiving_id, $cargo->id], 'id' => 'form_cargo']) }}
	{{ Form::hidden('cargo_id', $cargo->id) }}
	{{ Form::hidden('receiving_id', $cargo->receiving_id) }}

	<div class="row">
		<div class="col-md-12 ">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-info"></i>Cargo
					</div>
				</div>
				<div class="portlet-body">

					<div class="form-group">
						{{ Form::label('bl_no', 'B/L No', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
							{{ Form::text('bl_no', $cargo->bl_no, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'B/L No']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('consignor_id', 'Consignor', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-male"></i></span>
							{{ Form::text('consignor_id',$cargo->consignor->id, ['class'=>'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('consignee_id', 'Consignee', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-male"></i></span>
							{{ Form::text('consignee_id',$cargo->consignee->id, ['class'=>'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('mt', 'MT', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
							{{ Form::text('mt', $cargo->mt, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'MT']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('m3', 'M3', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
							{{ Form::text('m3', $cargo->m3, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'M3']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('description', 'Description', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
							{{ Form::textarea('description', $cargo->description, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Description', 'rows' => '3']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('markings', 'Markings', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
							{{ Form::textarea('markings', $cargo->markings, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Markings', 'rows' => '2']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('country_code', 'Port of Discharge: Country', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-male"></i></span>
							{{ Form::select('country_code', $country, $cargo->country_code, ['class' => 'form-control select-select2']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('port_code', 'Port of Discharge: Port Code (eg. MYLBU, SGSIN, INMAA)', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
							{{ Form::text('port_code', $cargo->port_code, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Port Code']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('custom_reg_no', 'Custom Registration No', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
							{{ Form::text('custom_reg_no', $cargo->custom_reg_no, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Custom Registration No']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('custom_form_no', 'Custom Form No (eg. K1, K2, K8)', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
							{{ Form::select('custom_form_no', [null => "Custom Form No"] + ['K1'=>'K1', 'K1A'=>'K1A', 'K2'=>'K2', 'K3'=>'K3', 'K8'=>'K8', 'K9'=>'K9'], $cargo->custom_form_no, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off']) }}
						</div>
					</div>

					<div class="form-actions">
						<button type="submit" id="register-submit-btn" class="btn blue" data-confirm>
						Update <i class="m-icon-swapright m-icon-white"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	{{ Form::close() }}

@stop

@section('page_level_plugins')
@stop

@section('scripts')

	select2Plugin('#consignor_id', "{{route('workorders.handler_list')}}", "{{$cargo->consignor->name}}", "Please select a consignor");
	select2Plugin('#consignee_id', "{{route('workorders.handler_list')}}", "{{$cargo->consignee->name}}", "Please select a consignee");
@stop


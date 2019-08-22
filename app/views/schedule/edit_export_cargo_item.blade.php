@extends('layouts/default')

@section('page_level_styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>
@stop
@section('content')

	<h3 class="page-title">
		Cargo Item Id:{{ $cargoItem->id }} <small>edit</small>
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
				<a href="{{ route('manifest.schedule.export', $schedule->id ) }}"> {{ $schedule->vessel->name}} v.{{ $schedule->voyage_no_departure }}</a>
				<i class="fa fa-angle-right"></i>
			</li>	
			<li>
				<a href="{{ route('manifest.schedule.export.cargoes.show', [$schedule->id, $cargo->id] ) }}"> {{ $cargo->bl_no }}</a>
				<i class="fa fa-angle-right"></i>
			</li>					
			<li>
				Edit Item ID: {{ $cargoItem->id }}
			</li>						
		</ul>
	</div>	

	{{ Form::open(['route'=>['manifest.schedule.export.cargoes.item.update', $schedule->id, $cargo->id, $cargoItem->id]]) }}
	{{ Form::hidden('cargo_item_id', $cargoItem->id) }}
	{{ Form::hidden('export_vessel_schedule_id', $cargo->export_vessel_schedule_id) }}

	<div class="row">
		<div class="col-md-8 ">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-info"></i>Cargo Item
					</div>
				</div>
				<div class="portlet-body">

					<div class="form-group">
						{{ Form::label('custom_tariff_code', 'Custom Tariff Code', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
							{{ Form::text('custom_tariff_code', $cargoItem->custom_tariff_code, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Custom Tariff Code']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('description', 'Description', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
							{{ Form::textarea('description', $cargoItem->description, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Description', 'rows' => '2']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('quantity', 'Quantity', ['class' => 'control-label']) }}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-check"></i></span>
							{{ Form::text('quantity', $cargoItem->quantity, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Quantity']) }}
						</div>
					</div>

					<div class="form-actions">
						<button type="submit" id="register-submit-btn" class="btn blue">
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


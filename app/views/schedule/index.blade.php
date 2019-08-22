@extends('layouts/default')

@section('page_level_styles')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<!-- END PAGE LEVEL STYLES -->
@stop
@section('content')

	<h3 class="page-title">
		Vessel Schedule <small>list</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Schedule
			</li>					
		</ul>
	</div>	



<div class="portlet box blue-hoki">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-anchor"></i>Vessel Schedule
		</div>
		<div class="tools">
			{{ Form::open(['class' => 'form-inline']) }}
			<div class="form-group">
			{{ Form::text('view_date', Session::get('view_date'), ['class' => 'form-control form-control-inline input-sm month-picker', 'placeholder' => 'Month']) }}
			</div>
			<div class="form-group">
				<button type="submit" id="register-submit-btn" class="btn btn-sm blue">
				View <i class="m-icon-swapright m-icon-white"></i>
				</button>
			</div>
			{{ Form::close() }}
		</div>
	</div>
	<div class="portlet-body">
		<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-condensed">
		<thead>
		<tr>
			<th rowspan="2" style="text-align:center;vertical-align:middle">ID</th>
			<th rowspan="2" style="text-align:center;vertical-align:middle">Vessel</th>
			<th rowspan="2" style="text-align:center;vertical-align:middle">Agent</th>
			<th rowspan="2" style="text-align:center;vertical-align:middle">MT</th>
			<th rowspan="2" style="text-align:center;vertical-align:middle">M3</th>
			<th rowspan="2" style="text-align:center;vertical-align:middle">Cont</th>
			<th colspan="2" style="text-align:center;vertical-align:middle;border-bottom: 1px solid #ccc;">Import</th>
			<th colspan="2" style="text-align:center;vertical-align:middle;border-bottom: 1px solid #ccc;">Export</th>
			<th rowspan="2" style="text-align:center;vertical-align:middle">Action</th>
		</tr>
		<tr>
			<th style="text-align:center;vertical-align:middle">Voy #</th>
			<th style="text-align:center;vertical-align:middle">ETA</th>

			<th style="text-align:center;vertical-align:middle">Voy #</th>
			<th style="text-align:center;vertical-align:middle">ETD</th>
					
		</tr>
		</thead>
		<tbody>
			@foreach($vesselSchedule as $schedule)
				<tr>
					<td>LP{{ $schedule->registered_vessel_id }}</td>	
					<td>{{ $schedule->vessel->name }}</td>	
					<td>
						@if(! $schedule->portuser == 0)
							{{ $schedule->portUser->name }}
						@else
							-
						@endif
					</td>
					<td>{{ number_format($schedule->mt_arrival,2) }}</td>
					<td>{{ number_format($schedule->m3_arrival,2) }}</td>
					<td align="center">{{ count($schedule->importContainers) }}</td>
					<td>{{ $schedule->voyage_no_arrival }}</td>								
					<td>{{ $schedule->eta->format('d/m/Y') }}</td>

					<td>{{ $schedule->voyage_no_departure }}</td>	
					<td>
						 {{ ($schedule->etd->year == '-1') ? 'TBA': $schedule->etd->format('d/m/Y') }}
					</td>
					
					<td>
						 {{ link_to_route('manifest.schedule.import', 'Import', ['id' => $schedule->id]) }} | 
						 {{ link_to_route('manifest.schedule.export', 'Export', ['id' => $schedule->id]) }} |
						 {{ link_to_route('manifest.schedule.edit', 'Edit', ['id' => $schedule->id]) }}
					</td>										
				</tr>
			@endforeach
		</tbody>
		</table>
		</div>
	</div>
</div>


@stop

@section('page_level_plugins')

<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>


@stop

@section('page_level_scripts')

<script src="{{ URL::asset('assets/admin/pages/scripts/components-pickers.js') }}"></script>

@stop

@section('scripts')
	ComponentsPickers.init();
@stop
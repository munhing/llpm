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
		Cargoes <small>list</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Cargoes
			</li>					
		</ul>
	</div>	



<div class="portlet box blue-hoki">
	<div class="portlet-title">
		<div class="caption">
			Cargo
		</div>
		<div class="tools">

		</div>
	</div>
	<div class="portlet-body">
		<div class="table-responsive">

			{{ Form::open() }}

				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th></th>
							<th>BL #</th>
							<th>Vessel</th>
							<th>Consignee / Shipper</th>
							<th>MT</th>
							<th>M3</th>
							<th>Description</th>
							<th>Status</th>
							<th>Container(s)</th>
						</tr>
					</thead>
					<tbody>
						<?php $count = 1;?>
						@foreach($cargoes as $cargo)
						<tr>
							<td>
								{{ $count }}
							</td>
							<td>
								{{ cargoMovementTranslator($cargo->import_vessel_schedule_id) }} {{ $cargo->bl_no }}	
							</td>
							<td>
								@if($cargo->import_vessel_schedule_id == 0)
									{{ $cargo->vessel_schedule_export }}
								@else
									{{ $cargo->vessel_schedule_import }}
								@endif
							</td>
							<td>
								@if($cargo->import_vessel_schedule_id == 0)
									{{ $cargo->shipper_name }}
								@else
									{{ $cargo->consignee_name }}
								@endif								
							</td>
							<td>{{ $cargo->mt }}</td>
							<td>{{ $cargo->m3 }}</td>
							<td>{{ $cargo->description }}</td>
							<td>{{ cargoStatusTranslator($cargo->status, $cargo->import_vessel_schedule_id) }}</td>
							<td>
								@foreach($cargo->containers as $ctn)
									{{ $ctn->container_no }}
								@endforeach
							</td>
						</tr>
						<?php $count++; ?>
						@endforeach
					</tbody>
				</table>

			{{ Form::close() }}

		</div>
	</div>
</div>


@stop

@section('page_level_plugins')


@stop

@section('page_level_scripts')


@stop

@section('scripts')

@stop
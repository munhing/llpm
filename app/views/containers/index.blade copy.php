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
		Containers <small>list</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Containers
			</li>					
		</ul>
	</div>	



<div class="portlet box blue-hoki">
	<div class="portlet-title">
		<div class="caption">
			Containers 
		</div>
		<div class="tools">

		</div>
	</div>
	<div class="portlet-body">
		<div class="table-responsive">
		
			<h3>Total Storage Charges: RM {{ number_format($totalStorageCharges, 2)}} </h3>

			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Container #</th>
						<th>Size</th>
						<th>Location</th>
						<th>Mode of Arrival</th>
						<th>Received On</th>
						<th>Total Days</th>
						<th>Days Empty</th>
						<th>Days Laden</th>
						<th>Storage Charges</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; ?>
					@foreach($containers as $container)
					<tr>
						<td>{{ $i }}</td>
						<td>{{ link_to_route('containers.show', $container->container_no, $container->id) }}</td>
						<td>{{ $container->size . $container->content }}</td>
						<td>{{ $container->location }}</td>
						<td>{{ $container->workorders->first()->movement . " - " . $container->workorders->first()->id }}</td>
						<td>{{ $container->workorders->first()->pivot->updated_at->format('d/m/Y') }}</td>
						<td>{{ $container->days_total }}</td>
						<td>{{ $container->days_empty }}</td>
						<td>{{ $container->days_laden }}</td>
						<td>{{ number_format($container->storage_charges, 2) }}</td>
					</tr>
					<?php $i++ ?>
					@endforeach
				</tbody>
			</table>
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
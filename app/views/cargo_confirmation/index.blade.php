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
		Import Cargo Confirmation <small>list</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Confirmation
			</li>					
		</ul>
	</div>	



<div class="portlet box blue-hoki">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-anchor"></i>Import Cargo
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
							<th>Consignee</th>
							<th>MT</th>
							<th>M3</th>
							<th>Description</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach($cargoes as $cargo)
						<tr>
							<td>
								@if($cargo->containers->count() == 0)
									{{ Form::checkbox('confirmationId[]', $cargo->id . '-' . $cargo->status ) }}
								@else
									<span class="badge badge-info badge-roundless">Containerized</span>
								@endif
							</td>
							<td>
								{{ $cargo->bl_no }}							
							</td>
							<td>{{ $cargo->vessel_schedule_import }}</td>
							<td>{{ $cargo->consignee_name }}</td>
							<td>{{ $cargo->mt }}</td>
							<td>{{ $cargo->m3 }}</td>
							<td>{{ $cargo->desciption }}</td>
							<td>{{ cargoStatusTranslator($cargo->status, $cargo->import_vessel_schedule_id) }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>

                <button class='btn btn-sm blue' data-confirm>
                    Confirm <i class="m-icon-swapright m-icon-white"></i>
                </button>											


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
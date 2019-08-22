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
		Container No: {{ $container->container_no }} <small>information</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('containers') }}">Containers</a>
				<i class="fa fa-angle-right"></i>
			</li>			
			<li>
				{{ $container->container_no }}
			</li>					
		</ul>
	</div>	



<div class="portlet box blue-hoki">
	<div class="portlet-title">
		<div class="caption">
			Activity
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
							<th>No</th>
							<th>Work Order #</th>
							<th>Movement</th>
							<th>Date</th>
							<th>Confirmed On</th>
							<th>Confirmed By</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; ?>
						@foreach($container->workorders as $workorder)
						<?php $confirmed_at = DateTime::createFromFormat('Y-m-d H:i:s', $workorder->pivot->confirmed_at); ?>
						<tr>
							<td>{{ $i }}</td>
							<td>{{ $workorder->id }}</td>
							<td>{{ $workorder->movement }}</td>
							<td>{{ $workorder->date->format('d/m/Y') }}</td>
							<td>
								@if($workorder->pivot->confirmed == 1)
									{{ $confirmed_at->format('d/m/Y H:i') }}
								@endif
							</td>
							<td>
								@if($workorder->pivot->confirmed == 1)
									{{ $workorder->users_name }}
								@endif
							</td>
						</tr>
						<?php $i++ ?>
						@endforeach
					</tbody>
				</table>

				<button type="submit" id="register-submit-btn" class="btn blue hide">
				Confirm <i class="m-icon-swapright m-icon-white"></i>
				</button>

			{{ Form::close() }}

		</div>
	</div>
</div>


@stop

@section('page_level_plugins')

@{{<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>}}
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
@{{ <script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script> }}
@{{ <script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script> }}
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>


@stop

@section('page_level_scripts')

<script src="{{ URL::asset('assets/admin/pages/scripts/table-advanced.js') }}"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-pickers.js') }}"></script>

@stop

@section('scripts')
	//TableAdvanced.init();
	ComponentsPickers.init();
@stop	

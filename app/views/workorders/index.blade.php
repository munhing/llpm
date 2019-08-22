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
		Work Order <small>list</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Work Order
			</li>					
		</ul>
	</div>	

{{ Session::get('workorder.movement') }}

<div class="portlet box blue-hoki">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-anchor"></i>Work Order
		</div>
		<div class="tools">
			{{ Form::open(['class' => 'form-inline']) }}
			<div class="form-group">
			{{ Form::select('view_movement', [null => "Filter by movement"] + $movement, Session::get('workorder.movement'), ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Role']) }}
			</div>			
			<div class="form-group">
			{{ Form::text('view_date', Session::get('workorder.date'), ['class' => 'form-control form-control-inline input-sm month-picker', 'placeholder' => 'Month']) }}
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
                     {{ $checkDate }}
		<table class="table table-striped table-bordered table-hover table-condensed">
		<thead>
			<tr>
				<th>Work Order #</th>
				<th>Movement</th>
				<th>Date</th>
				<th>Carrier</th>	
				<!-- <th>Bond</th>	-->
				<th>Storage</th>	
				<th>Handling</th>	
				<th>Issued By</th>	
				<th>Action</th>	
			</tr>
		</thead>
		<tbody>
			@foreach($workorders as $workorder)
				<?php $movement = explode('-', $workorder->movement); ?>
				<tr>
					<td>{{ link_to_route('workorders.show', $workorder->id, $workorder->id) }}</td>	
					<td>{{ $workorder->movement }}</td>
					<td>{{ $workorder->date->format('d/m/Y') }}</td>
					<td>{{ $workorder->getCarrier() }}</td>								
					<!-- <td align="right">
						@if(! ( ($movement[0] == 'HE' || $movement[0] == 'US' || ($movement[0] == 'RO' && $movement[1] == '1') ) ))
							-
						@else

							@if($workorder->finalized == 1)

								<a href="{{ URL::route('workorders.generate.bond', $workorder->id) }}" target="_blank">
									{{ number_format($workorder->bond_rent, 2) }}
								</a>
							@else
								<span class="font-red-thunderbird">Not finalized.</span>
							@endif

						@endif

					</td> -->
					<td align="right">
							@if(! ($movement[0] == 'HE' || $movement[0] == 'RO'))
								-
							@else
								
								@if($workorder->finalized == 1)

									<a href="{{ URL::route('workorders.generate.storage', $workorder->id) }}" target="_blank">
										{{ number_format($workorder->storage_charges, 2) }}
									</a>
								@else
									<span class="font-red-thunderbird">Not finalized.</span>
								@endif	
							@endif						
					</td>
					<td align="right">
						<a href="{{ URL::route('workorders.generate.handling', $workorder->id) }}" target="_blank">
							{{ number_format($workorder->handling_charges, 2) }}
						</a>						
					</td>
					<td>
						@if(!is_null($workorder->user))
							{{ $workorder->user->name }}
						@endif
					</td>
					<td>
						<a href="{{ URL::route('workorders.generate', $workorder->id) }}" target="_blank">
							<i class="fa fa-file-text-o"></i>
						</a>
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

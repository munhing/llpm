@extends('layouts/default')

@section('page_level_styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>
@stop
@section('content')

	<?php $movement = explode('-', $workOrder->movement);	?>

	<h3 class="page-title">
		Work Order #: {{ $workOrder->id }} <small>information</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('workorders') }}">Work Order</a>
				<i class="fa fa-angle-right"></i>
			</li>			
			<li>
				{{ $workOrder->id }}
			</li>						
		</ul>
	</div>	

	<div class="row">
		
		<div class="col-md-4 ">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-info"></i>Work Order
					</div>

					
					<div class="actions">

						{{ Form::open(['route' => ['workorders.finalize', $workOrder->id]]) }}

							@if($workOrder->finalized == 0)
	                            <button class='btn btn-sm btn-success' data-confirm="Finalize this workorder?">
	                                Finalize
	                            </button>											
							@endif
															


							<a href="{{ URL::route('workorders.generate', $workOrder->id) }}" class="btn btn-default btn-sm" target="_blank">
								<i class="fa fa-file-text-o"></i> View 
							</a>


							<a href="#" class="btn btn-default btn-sm">
								<i class="fa fa-edit"></i> Edit 
							</a>
						{{ Form::close() }}

					</div>
					

				</div>
				<div class="portlet-body">
					<div class="row static-info">
						<div class="col-md-4 name name">
							Work Order #:
						</div>
						<div class="col-md-8 name value">
							{{ $workOrder->id }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-4 name">
							Nature of Work:
						</div>
						<div class="col-md-8 value">
							{{ $workOrder->movement }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-4 name">
							Date:
						</div>
						<div class="col-md-8 value">
							{{ $workOrder->date->format('d/m/Y') }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-4 name">
							Handler:
						</div>
						<div class="col-md-8 value">
							@if(!is_null($workOrder->handler))
								{{ $workOrder->handler->name }}
							@endif						
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-4 name">
							Carrier:
						</div>
						<div class="col-md-8 value">
							{{ $workOrder->getCarrier() }}
						</div>						
					</div>
					<!-- <div class="row static-info">
						<div class="col-md-4 name">
							Bond Rent:
						</div>
						<div class="col-md-8 value">
							@if(! ( ($movement[0] == 'HE' || $movement[0] == 'US' || ($movement[0] == 'RO' && $movement[1] == '1') ) ))
								Nil
							@else

								@if($workOrder->finalized == 1)
									{{ number_format($workOrder->bond_rent, 2) }}
									<a href="{{ URL::route('workorders.generate.bond', $workOrder->id) }}" class="btn btn-default btn-sm" target="_blank">
										Details
									</a>

									<a href="{{ URL::route('workorders.recalculate.bond', $workOrder->id) }}" class="btn btn-default btn-sm">
										<i class="fa fa-calculator"></i> Recalculate
									</a>													
								@else
									<span class="font-red-thunderbird">Bond Rent will only be displayed after workorder is finalized.</span>
								@endif	

							@endif
						</div>						
					</div>	-->				
					<div class="row static-info">
						<div class="col-md-4 name">
							Storage Charges:
						</div>
						<div class="col-md-8 value">
							@if(! ($movement[0] == 'HE' || $movement[0] == 'RO'))
								Nil
							@else
								
								@if($workOrder->finalized == 1)

									
									<a href="{{ URL::route('workorders.generate.storage', $workOrder->id) }}" target="_blank">
										{{ number_format($workOrder->storage_charges, 2) }}
									</a>

									@if($workOrder->agent_id == 0)
										<a href="#myModal_selectAgent" role="button" class="btn btn-default btn-sm" data-toggle="modal">
											Select Agent
										</a>										
									@endif

									<a href="{{ URL::route('workorders.recalculate.storage', $workOrder->id) }}" class="btn btn-default btn-sm">
										<i class="fa fa-calculator"></i> Recalculate
									</a>													
								@else
									<span class="font-red-thunderbird">Storage charges will only be displayed after workorder is finalized.</span>
								@endif	
							@endif		
						</div>						
					</div>
					<div class="row static-info">
						<div class="col-md-4 name">
							Handling Charges:
						</div>
						<div class="col-md-8 value">
							
							<a href="{{ URL::route('workorders.generate.handling', $workOrder->id) }}" target="_blank">
								{{ number_format($workOrder->handling_charges, 2) }}
							</a>
							<a href="{{ URL::route('workorders.recalculate', $workOrder->id) }}" class="btn btn-default btn-sm">
								<i class="fa fa-calculator"></i> Recalculate
							</a>							
						</div>						
					</div>	
					<div class="row static-info">
						<div class="col-md-4 name">
							Issued by:
						</div>
						<div class="col-md-8 value">
							@if(!is_null($workOrder->user))
								{{ $workOrder->user->name }}
							@endif
						</div>						
					</div>									
				</div>
			</div>
		</div>

		{{ Form::open(['route' => ['workorders.containers.add', $workOrder->id], 'id' => 'form_add_container']) }}	

		<div id="myModal_autocomplete" class="modal fade" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Add Containers</h4>
					</div>
					<div class="modal-body form">
						
						
						<div class="form-horizontal form-row-seperated">
							<div class="form-group">
								<div class="col-sm-12">
									<div class="input-group">
										<span class="input-group-addon">
										<i class="fa fa-user"></i>
										</span>
										{{ Form::select('containers[]', [], null, ['class' => 'form-control select2me', 'placeholder' => 'Select Containers', 'multiple', 'id'=>'ctn', 'spinner']) }}
									</div>
								</div>
							</div>
						</div>	
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-primary" id="but_add_container" data-confirm>
					</div>
				</div>
			</div>
		</div>
		{{ Form::close() }}	

		{{ Form::open(['route' => ['workorders.agent', $workOrder->id]]) }}	

		<div id="myModal_selectAgent" class="modal fade" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Select Agent</h4>
					</div>
					<div class="modal-body">
												
						<div class="form-horizontal">
							<div class="form-group">
	                            <div class="col-md-12">
            						<label class="control-label col-md-2">Agent</label>
            						<div class="col-md-10">
            							{{ Form::hidden('agent_id','', ['id'=>'agent_id','class'=>'form-control', 'data-placeholder'=>"Choose an agent..."]) }}
            						</div>
	                            </div>  
							</div>
						</div>	
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-primary" id="but_add_container" data-confirm>
					</div>
				</div>
			</div>
		</div>
		{{ Form::close() }}
		<div class="col-md-8">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box red">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-info"></i>Containers
					</div>
					<div class="actions inline">

						@if($workOrder->finalized == 0)					
							<a href="#myModal_autocomplete" role="button" class="btn btn-default btn-sm" data-toggle="modal">
								<i class="fa fa-plus"></i> Add
							</a>
						@endif

					</div>					
				</div>
				<div class="portlet-body">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Container #</th>
									<th>Size</th>
									<th>Confirmed By</th>
									<th>Confirmed Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; ?>
								<?php ?>
								@foreach($workOrder->containers as $container)
									@if($container->pivot->confirmed != 0)
										<?php $confirmed_at = Datetime::createFromFormat('Y-m-d H:i:s', $container->pivot->confirmed_at)->format('d/m/Y H:i'); ?>
									@else
										<?php $confirmed_at = ''; ?>
									@endif

									<tr>
										<td>{{ $i }}</td>
										<td>{{ $container->container_no }} {{ $container->pivot->remark == 'BYPASS' ? '<span class="label label-sm label-danger">bypass</span>' : '' }}</td>
										<td>{{ $container->size . $container->pivot->content }}</td>
										<td>@if($container->pivot->confirmed_by != 0)
											{{ $container->users_name }}
											@endif
										</td>
										<td>{{ $confirmed_at }}</td>
										<td>@if($container->pivot->confirmed == 0)
											{{ Form::open(['id' => 'form_unlink_container']) }}
											{{ Form::hidden('container_id', $container->id) }}
					                            <button class='btn btn-sm btn-danger' data-confirm="Cancel this container?">
					                                <i class="glyphicon glyphicon-remove"></i>
					                            </button>											
											{{ Form::close() }}
											@endif
										</td>
									</tr>
								<?php $i++; ?>
								@endforeach
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>

@stop

@section('page_level_plugins')
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-pickers.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-dropdowns.js') }}"></script>
@stop

@section('page_level_scripts')
<script type="text/javascript" src="{{ URL::asset('assets/app/js/app.js') }}"></script>
@stop

@section('scripts')
ComponentsPickers.init();
ComponentsDropdowns.init();

$(function() {

	$.ajax({
		url: '{{ route('workorders.container_list') }}',
		dataType: 'json',
		type: 'GET',
		data: {carrier_id : {{ $workOrder->vessel_schedule_id }}, type : '{{ $workOrder->movement }}' },
		success: function(data) {

			console.log(data);

			$('#ctn').select2('data', null);
			$('#ctn').empty(); // clear the current elements in select box

			for (row in data) {
				$('#ctn').append($('<option></option>').attr('value', data[row].id).text(data[row].container_no));
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		}
	});

	$('#agent_id').select2({
		minimumInputLength: 4,
		ajax: {
			url: '{{ route('workorders.handler_list') }}',
			quietMillis: 1000,
			type: 'GET',
			data: function (term, page) {
				return {
					q:term
				};
			},
			results: function (data, page) {
				console.log(data);
				return {
					results: data
				};
			}
		},
	});
});
@stop


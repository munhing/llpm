@extends('layouts/default')

@section('page_level_styles')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<!-- END PAGE LEVEL STYLES -->
@stop
@section('content')

	<h3 class="page-title">
		Receiving <small>receiving</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('receiving') }}">Receiving</a>
				<i class="fa fa-angle-right"></i>
			</li>			
			<li>
				Receiving
			</li>					
		</ul>
	</div>	

<!-- Begin: life time stats -->
	<div class="row">
		<div class="col-md-4 ">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-info"></i>Containers
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
									<th>E/L</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; ?>
								@foreach($containers as $container)
									<?php $woRI = getWorkOrderRI($container->workorders); ?>
									<tr>
										<td>{{ $i }}</td>
										<td>{{ $container->container_no }}</td>
										<td>{{ $container->size }}</td>
										<td>{{ $container->content }}</td>
										<td>

											<?php $role = Auth::user()->roles->first()->role; ?>
											@if($role == 'AD' || $role == 'IT')
					                            <button class='btn btn-xs btn-primary' type='button' data-toggle="modal" data-target="#formModal" data-container-id="{{$container->id}}" data-container-no="{{ $container->container_no }}" data-size="{{ $container->size }}">
					                                <i class="fa fa-edit"></i>
					                            </button>										
											@endif

											@if(count($container->workorders) == 0 && $container->content != 'L')
												{{ Form::open(['route'=>['receiving.container.delete', $container->receiving_id]]) }}
												{{ Form::hidden('container_id', $container->id) }}
						                            <button class='btn btn-sm btn-danger' data-confirm>
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
				<!-- END Portlet PORTLET-->
		</div>		

		<div class="col-md-8">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box red">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-info"></i>Export Cargoes
					</div>
				</div>
				<div class="portlet-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>B/L #</th>
									<th>Consignor</th>
									<th class="hide">Consignee</th>
									<th>Description</th><th>Containers</th>
									<th>Vessel</th>
									<th>MT</th>
									<th>M3</th>
									<th>Status</th>
									<th></th>
								</tr>
							</thead>							
							<tbody>
								<?php $i=1; ?>
								@foreach($receiving->cargoes as $cargo)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ link_to_route('receiving.cargo.show', $cargo->bl_no, [$cargo->receiving_id, $cargo->id]) }}</td>
										<td>{{ $cargo->consignor->name }}</td>
										<td class="hide">{{ $cargo->consignee->name }}</td>
										<td>{{ $cargo->description }}</td><td>{{ listContainersInString2($cargo->containers) }}</td>
										<td>{{ $cargo->vessel_schedule_export }}</td>
										<td align="right">{{ number_format($cargo->mt, 2) }}</td>
										<td align="right">{{ number_format($cargo->m3, 2) }}</td>
										<td>{{ exportCargoStatusTranslator($cargo->status) }}</td>
										<td>{{ link_to_route('receiving.cargo.edit', 'Edit', [$cargo->receiving_id, $cargo->id]) }}</td>										
									</tr>
								<?php $i++; ?>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- END Portlet PORTLET-->
		</div>
	</div>
	<!-- END Portlet PORTLET-->

	<div class="modal fade edit-modal-sm" id="formModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	    <div class="modal-dialog modal-sm">
	          <div class="modal-content">
	                <div class="modal-header">
	                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                      <h4 class="modal-title">Edit Container</h4>
	                </div>
	                <div class="modal-body">
	                        {{ Form::open(['route'=>'receiving.containers.edit']) }}    
                                {{ Form::hidden('container_id', '', ['id'=>'container_id']) }}
                                {{ Form::hidden('container_no_old', '', ['id'=>'container_no_old']) }}
                                {{ Form::hidden('size_old', '', ['id'=>'size_old']) }}
                                <div class="form-group">
                                     {{ Form::label('container_no','Container No') }}
                                     {{ Form::text('container_no','', ['class'=>'form-control']) }}
                                </div>    
                                <div class="form-group">
                                     {{ Form::label('size','Size') }}
                                     {{ Form::text('size','', ['class'=>'form-control']) }}
                                </div>                       

                                <button class="btn btn-lg btn-success btn-block edit-btn" data-confirm>
                                    Update
                                </button>
	                        {{ Form::close() }}
	                </div>
	          </div>
	    </div>
	</div>
				
	<div class="clearfix">
	</div>
@stop

@section('page_level_plugins')

@stop

@section('page_level_scripts')

@stop

@section('scripts')

	$('#formModal').on('show.bs.modal', function (event) {
	
		var button = $(event.relatedTarget); // Button that triggered the modal

		var container_id = button.data('container-id'); // Extract info from data-* attributes
        var container_no = button.data('container-no'); // Extract info from data-* attributes
		var size = button.data('size'); // Extract info from data-* attributes

		var modal = $(this);

        modal.find('.modal-title').text('Edit ' + container_no);
        modal.find('#container_id').val(container_id);
        modal.find('#container_no').val(container_no);
        modal.find('#container_no_old').val(container_no);
        modal.find('#size').val(size);
        modal.find('#size_old').val(size);
	});
	
@stop

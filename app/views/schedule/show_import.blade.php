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
		MV. {{ $vesselSchedule->vessel->name}} v.{{ $vesselSchedule->voyage_no_arrival}} <small>import</small>
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
				Import
			</li>					
		</ul>
	</div>	

<!-- Begin: life time stats -->



	<div class="row">
		<div class="col-md-12">
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-info"></i>Vessel Information
					</div>
				</div>

				<div class="portlet-body">
					<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover table-condensed">
					<thead>
					<tr>
						<th style="text-align:center;vertical-align:middle">Vessel</th>
						<th style="text-align:center;vertical-align:middle">MT</th>
						<th style="text-align:center;vertical-align:middle">M3</th>
						<th style="text-align:center;vertical-align:middle">Cont</th>					
					</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{ $vesselSchedule->getVesselVoyageAttribute() }}</td>	
							<td>{{ number_format($vesselSchedule->mt_arrival,2) }}</td>
							<td>{{ number_format($vesselSchedule->m3_arrival,2) }}</td>
							<td align="center">{{ count($vesselSchedule->importContainers) }}</td>
						</tr>
					</tbody>
					</table>
					Goto {{ link_to_route('manifest.schedule.export', 'Export', ['id' => $vesselSchedule->id]) }}
					</div>
				</div>
			</div>		
		</div>
		<div class="col-md-4 ">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-info"></i>Containers
					</div>
					<div class="actions">
						<a href="{{ route('manifest.schedule.import.containers.create', $vesselSchedule->id) }}" class="btn btn-default btn-sm">
							<i class="fa fa-plus"></i> Add Empty Containers
						</a>
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
								@foreach($vesselSchedule->importContainers as $container)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ identifyPendingContainerInVessel($container->container_no, $containers_status1, 'import') }} {{ $container->is_soc == '1' ? '<span class="label label-sm label-warning">SOC</span>' : '' }}</td>
										<td>{{ $container->size }}</td>
										<td>{{ $container->m_content }}</td>
										<td>
											<?php $role = Auth::user()->roles->first()->role; ?>
											@if($role == 'AD' || $role == 'IT')
					                            <button class='btn btn-xs btn-primary' type='button' data-toggle="modal" data-target="#formModal" data-container-id="{{$container->id}}" data-container-no="{{ $container->container_no }}" data-size="{{ $container->size }}">
					                                <i class="fa fa-edit"></i>
					                            </button>										
											@endif

											@if(count($container->workorders) == 0 && $container->content != 'L')												
												{{ Form::open(['route'=>['manifest.schedule.import.containers.delete', $container->import_vessel_schedule_id], 'id' => 'form_remove_container']) }}
												{{ Form::hidden('container_id', $container->id) }}
						                            <button class='btn btn-sm btn-danger' data-confirm="Remove this container?">
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
						<i class="fa fa-info"></i>Cargoes
					</div>
					<div class="actions">
						<a href="{{ route('manifest.schedule.import.cargoes.create', $vesselSchedule->id) }}" class="btn btn-default btn-sm">
							<i class="fa fa-plus"></i> Add 
						</a>
					</div>
				</div>
				<div class="portlet-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>B/L #</th>
									<th class="hide">Consignor</th>
									<th>Consignee</th>
									<th>Description</th>
									<th>Containers</th>
									<th>MT</th>
									<th>M3</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>							
							<tbody>
								<?php $i=1; ?>
								@foreach($vesselSchedule->importCargoes as $cargo)
									<tr class="{{ $cargo->custom_form_no }}">
										<td>{{ $i }}</td>
										<td>{{ link_to_route('manifest.schedule.import.cargoes.show', $cargo->bl_no, [$cargo->import_vessel_schedule_id, $cargo->id]) }}</td>
										<td class="hide">{{ $cargo->consignor->name }}</td>
										<td>{{ $cargo->consignee->name }}</td>
										<td>{{ $cargo->description }}</td>
										<td>
											{{ listContainersInString($cargo->m_containers, $containers_status1, 'import') }}
										</td>
										<td align="right">{{ number_format($cargo->mt, 2) }}</td>
										<td align="right">{{ number_format($cargo->m3, 2) }}</td>
										<td>{{ importCargoStatusTranslator($cargo->status) }}</td>
										<td>
											{{ Form::open(['route'=>['manifest.schedule.import.cargoes.delete', $cargo->import_vessel_schedule_id]]) }}
											{{ Form::hidden('cargo_id', $cargo->id) }}

											{{ HTML::decode(link_to_route('manifest.schedule.import.cargoes.edit', '<i class="fa fa-edit"></i>', [$vesselSchedule->id, $cargo->id], ['class'=>'btn btn-xs btn-info'])) }}
											@if($cargo->status == 1 && $cargo->containerized == 0)
						                            <button class='btn btn-xs btn-danger' data-confirm>
						                                <i class="fa fa-remove"></i>
						                            </button>	
												@endif											
											{{ Form::close() }}
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
	                        {{ Form::open(['route'=>['manifest.schedule.import.containers.edit', $vesselSchedule->id]]) }}    
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

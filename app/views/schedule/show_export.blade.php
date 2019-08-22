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
		MV. {{ $vesselSchedule->vessel->name}} v.{{ $vesselSchedule->voyage_no_departure}} <small>export</small>
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
				Export
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
							<td>{{ $vesselSchedule->getVesselVoyageAttribute()}}</td>	
							<td>{{ number_format($vesselSchedule->mt_departure,2) }}</td>
							<td>{{ number_format($vesselSchedule->m3_departure,2) }}</td>
							<td align="center">{{ count($vesselSchedule->exportContainers) }}</td>
						</tr>
					</tbody>
					</table>
					
					Goto {{ link_to_route('manifest.schedule.import', 'Import', ['id' => $vesselSchedule->id]) }}
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
								</tr>
							</thead>
							<tbody>
								<?php $i=1; ?>
								@foreach($vesselSchedule->exportContainers as $container)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ identifyPendingContainerInVessel($container->container_no, $containers_status3, 'export', $vesselSchedule->exportContainers->lists('container_no'))}}</td>
										<td>{{ $container->size }}</td>
										<td>{{ $container->content }}</td>
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
								@foreach($vesselSchedule->exportCargoes as $cargo)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ link_to_route('manifest.schedule.export.cargoes.show', $cargo->bl_no, [$cargo->export_vessel_schedule_id, $cargo->id]) }}</td>
										<td>
											@if(count($cargo->consignor) != 0)
											{{ $cargo->consignor->name }}
											@endif
										</td>
										<td class="hide">
											@if(count($cargo->consignee) != 0)
											{{ $cargo->consignee->name }}
											@endif
										</td>
										<td>{{ $cargo->description }}</td>
										<td>{{ listContainersInString($cargo->containers, $containers_status3, 'export', $vesselSchedule->exportContainers->lists('container_no')) }}</td>
										<td align="right">{{ number_format($cargo->mt, 2) }}</td>
										<td align="right">{{ number_format($cargo->m3, 2) }}</td>
										<td>{{ exportCargoStatusTranslator($cargo->status) }}</td>
										<td>
											{{ Form::open(['route'=>['manifest.schedule.export.cargoes.delete', $cargo->export_vessel_schedule_id]]) }}
											{{ Form::hidden('cargo_id', $cargo->id) }}

											{{ HTML::decode(link_to_route('manifest.schedule.export.cargoes.edit', '<i class="fa fa-edit"></i>', [$vesselSchedule->id, $cargo->id], ['class'=>'btn btn-xs btn-info'])) }}
											@if(($cargo->status == 1 || $cargo->status == 2)  && $cargo->containerized == 0)
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

				
	<div class="clearfix">
	</div>
@stop

@section('page_level_plugins')

@stop

@section('page_level_scripts')

@stop

@section('scripts')
@stop

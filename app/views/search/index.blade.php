@extends('layouts/default')

@section('page_level_styles')

@stop
@section('content')

	<h3 class="page-title">
		Search <small>container, workorder, bl no</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Search 
			</li>					
		</ul>
	</div>	

	<div class="row">
			<!-- Cargo Search -->
		<div class="col-md-12">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<span class="panel-title bold uppercase"> Cargo</span>
					<span class="caption-helper">search</span>
				</div>
				<div class="panel-body">

					<div class="input-group">
						<input type="text" class="form-control" placeholder="Search for..." v-model="query_cargo">
						<input type="hidden" id="base_url" value="{{ url('/') }}">
						<span class="input-group-btn">
						<button class="btn btn-default" type="submit"><i class="icon-magnifier" @click="search_cargo"></i></button>
						</span>
				    </div>
				    <div class="text-danger" v-show="query_cargo.length < 5">* must be minimum 5 characters </div>

				    <hr />
				    
					<div v-show="data_cargo.total > 0">

						<table class="table table-striped">
							<thead>
								<tr>
									<th>BL #</th>
									<th>MT</th>
									<th>M3</th>
									<th>Consignee</th>
									<th>Description</th>
									<th>Received On</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="item in data_cargo.data" track-by="$index">
									<td><a href="@{{ cargoLink(item) }}" target="_blank">@{{ item.bl_no }}</a> <span class="badge">@{{ item.import_vessel_schedule_id == 0 ? 'Export' : 'Import' }}</span></td>
									<td align="right">@{{ item.mt | round 2 }}</td>
									<td align="right">@{{ item.m3 | round 2 }}</td>
									<td>@{{ item.import_vessel_schedule_id == 0 ? item.consignor.name : item.consignee.name }}</td>
									<td>@{{ item.description }}</td>
									<td>@{{ dateFormat(item.received_date) }}</td>
								</tr>
							</tbody>
						</table>

						<paginator name="cargo" :resource.sync="data_cargo" :query.sync="query_cargo" url="{{ route('search.cargo') }}" :min-query-length="5" ></paginator>

					</div>

					<p v-else>No results</p>		
				</div>			    
			</div>
		</div>
		<!-- End of Cargo Search -->

		<!-- Work Order Search -->
		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<span class="panel-title bold uppercase"> Work Order</span>
					<span class="caption-helper">search</span>
				</div>
				<div class="panel-body">

					<div class="input-group">
						<input type="text" class="form-control" placeholder="Search for..." v-model="query_workorder">
						<span class="input-group-btn">
						<button class="btn btn-default" type="submit"><i class="icon-magnifier" @click="search_workorder"></i></button>
						</span>
				    </div>
				    <div class="text-danger" v-show="query_workorder.length < 4">* must be minimum 4 characters </div>

				    <hr />

					<div v-show="data_workorder.total > 0">

						<table class="table table-striped">
							<thead>
								<tr>
									<th>Work Order #</th>
									<th>Movement</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="item in data_workorder.data" track-by="$index">
									<td><a href="{{ route('workorders') }}/@{{ item.id }}" target="_blank">@{{ item.id }}</a></td>
									<td>@{{ item.movement }}</td>
									<td>@{{ dateFormat(item.date) }}</td>
								</tr>
							</tbody>
						</table>

						<paginator name="workorder" :resource.sync="data_workorder" :query.sync="query_workorder" url="{{ route('search.workorder') }}" ></paginator>

					</div>

					<p v-else>No results</p>		
				</div>			    
			</div>
		</div>
		<!-- End of Work Order Search -->

		<!-- Container Search -->
		<div class="col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<span class="panel-title bold uppercase"> Container</span>
					<span class="caption-helper">search</span>
				</div>
				<div class="panel-body">

					<div class="input-group">
						<input type="text" class="form-control" placeholder="Search for..." v-model="query_container">
						<span class="input-group-btn">
						<button class="btn btn-default" type="submit"><i class="icon-magnifier" @click="search_container"></i></button>
						</span>
				    </div>
				    <div class="text-danger" v-show="query_container.length < 5">* must be minimum 5 characters </div>

				    <hr />
				    
					<div v-show="data_container.total > 0">

						<table class="table table-striped">
							<thead>
								<tr>
									<th>Container #</th>
									<th>Size</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="item in data_container.data" track-by="$index">
									<td><a href="{{ url('/') }}/admin/tracking/container/track?action=history&containers=@{{ item.container_no }}" target="_blank">@{{ item.container_no }}</a></td>
									<td>@{{ item.size }}</td>
								</tr>
							</tbody>
						</table>

						<paginator name="container" :resource.sync="data_container" :query.sync="query_container" url="{{ route('search.container') }}" :min-query-length="5"></paginator>

					</div>

					<p v-else>No results</p>		
				</div>			    
			</div>
		</div>
		<!-- End of Container Search -->



		<!-- Manifest Search -->
		<div class="col-md-6">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<span class="panel-title bold uppercase"> Manifest</span>
					<span class="caption-helper">search</span>
				</div>
				<div class="panel-body">

					<div class="input-group">
						<input type="text" class="form-control" placeholder="Search for..." v-model="query_manifest">
						<span class="input-group-btn">
						<button class="btn btn-default" type="submit"><i class="icon-magnifier" @click="search_manifest"></i></button>
						</span>
				    </div>
				    <div class="text-danger" v-show="query_manifest.length < 4">* must be minimum 4 characters </div>

				    <hr />
				    
					<div v-show="data_manifest.total > 0">

						<table class="table table-striped">
							<thead>
								<tr>
									<th>Vessel</th>
									<th>ETA</th>
									<th>ETD</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="item in data_manifest.data" track-by="$index">
									<td>MV. @{{ item.name + ' ' + item.voyage_no_arrival + ' | ' + item.voyage_no_departure }}</td>
									<td>@{{ dateFormat(item.eta) }}</td>
									<td>@{{ dateFormat(item.etd) }}</td>
									<td><a href="{{ url('/') }}/admin/manifest/schedule/@{{ item.id }}/import" target="_blank">Import</a> | <a href="http://llpm.app/admin/manifest/schedule/@{{ item.id }}/export" target="_blank">Export</a></td>
								</tr>
							</tbody>
						</table>

						<paginator name="manifest" :resource.sync="data_manifest" :query.sync="query_manifest" url="{{ route('search.manifest') }}" ></paginator>

					</div>

					<p v-else>No results</p>		
				</div>			    
			</div>
		</div>
		<!-- End of Manifest Search -->
	</div>

@stop

@section('page_level_plugins')


@stop

@section('page_level_scripts')
<script src="{{ URL::asset('js/search.js') }}"></script>

@stop

@section('scripts')
@stop
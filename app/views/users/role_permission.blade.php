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
		{{ $role->description }} <small>access</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('users') }}">Users</a>
				<i class="fa fa-angle-right"></i>
			</li>			
			<li>
				<a href="{{ URL::route('roles') }}">Roles</a>
				<i class="fa fa-angle-right"></i>
			</li>			
			<li>
				Access
			</li>					
		</ul>
	</div>	



<div class="portlet box blue-hoki">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-globe"></i>Access
		</div>
		<div class="tools">
		</div>
	</div>
	<div class="portlet-body">
		<table class="table table-striped table-bordered table-hover" id="sample_1">
		<thead>
		<tr>
            <th>Access</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
			@foreach($permissions as $permit)
				<tr>
                    <td>
                    	@if(! str_contains($permit->route_name, 'action.'))
                    		{{ link_to(route($permit->route_name), $permit->description) }}
                    	@else
                    		{{ $permit->description }}
                    	@endif
                    </td>
					<td>
                        @if($role->permissions->contains($permit->id))
                            <span class="label label-danger">Disallowed</span>
                        @else
                            <span class="label label-success">Allowed</span>
                        @endif               
                    </td>
					<td>
                        {{ Form::open() }}
                        {{ Form::hidden('permit_id', $permit->id) }}
						<button class="btn btn-xs btn-default" data-permit-id="{{ $permit->id }}" data-confirm>
                            @if($role->permissions->contains($permit->id))
                                Allow
                            @else
                                Disallow
                            @endif                        
						</button>
                        {{ Form::close() }}
					</td>
				</tr>
			@endforeach
		</tbody>
		</table>
	</div>
</div>

@stop

@section('page_level_plugins')

<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script> 
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>

@stop

@section('page_level_scripts')

<script src="{{ URL::asset('assets/admin/pages/scripts/table-advanced.js') }}"></script>

@stop

@section('scripts')
	TableAdvanced.init();
@stop
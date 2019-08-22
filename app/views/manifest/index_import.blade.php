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
		Manifest Import <small>information</small>
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
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-anchor"></i>Order #12313232 <span class="hidden-480">
				| Dec 27, 2013 7:16:25 </span>
			</div>
			<div class="actions">
				<a href="#" class="btn default yellow-stripe">
				<i class="fa fa-angle-left"></i>
				<span class="hidden-480">
				Back </span>
				</a>
				<div class="btn-group">
					<a class="btn default yellow-stripe dropdown-toggle" href="#" data-toggle="dropdown">
					<i class="fa fa-cog"></i>
					<span class="hidden-480">
					Tools </span>
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="#">
							Export to Excel </a>
						</li>
						<li>
							<a href="#">
							Export to CSV </a>
						</li>
						<li>
							<a href="#">
							Export to XML </a>
						</li>
						<li class="divider">
						</li>
						<li>
							<a href="#">
							Print Invoice </a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="portlet-body">
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

@stop

@section('page_level_scripts')

<script src="{{ URL::asset('assets/admin/pages/scripts/table-advanced.js') }}"></script>

@stop

@section('scripts')
	TableAdvanced.init();
@stop
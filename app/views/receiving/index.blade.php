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
		Receiving Advice <small>list</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Receving Advice
			</li>					
		</ul>
	</div>	



<div class="portlet box blue-hoki">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-anchor"></i>Receiving Advice
		</div>
		<div class="tools">
			{{ Form::open(['class' => 'form-inline']) }}
			<div class="form-group">
			{{ Form::text('view_date', Session::get('receiving.date'), ['class' => 'form-control form-control-inline input-sm month-picker', 'placeholder' => 'Month']) }}
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
		<table class="table table-striped table-bordered table-hover">
		<thead>
		<tr>
			<th>Receiving Advice</th>
		</tr>
	
		</tr>
		</thead>
		<tbody>
			@foreach($receiving as $advice)
				<tr>
					<td>{{ link_to_route('receiving.show', $advice->date->format('d/m/Y'), $advice->id) }}</td>									
				</tr>
			@endforeach
		</tbody>
		</table>
		</div>
	</div>
</div>


@stop

@section('page_level_plugins')




@stop

@section('page_level_scripts')


@stop

@section('scripts')
	//TableAdvanced.init();
	// ComponentsPickers.init();

    $('.month-picker').datepicker({
        orientation: "left",
        format: 'mm/yyyy',
        viewMode: "months",
        minViewMode: "months",
        autoclose: true
    });
@stop
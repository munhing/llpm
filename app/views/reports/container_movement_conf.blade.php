@extends('layouts/default')

@section('page_level_styles')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<!-- END PAGE LEVEL STYLES -->
@stop
@section('content')

	<h3 class="page-title">
		Container Movement <small>report</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('reports') }}">Reports</a>
                <i class="fa fa-angle-right"></i>
			</li>	
            <li>
                Report Settings
            </li>            				
		</ul>
	</div>	

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green-sharp">
                        <span class="caption-subject bold uppercase">Settings</span>
                    </div>    
                </div>
                <div class="portlet-body">

                    {{ Form::open() }}

                    <div class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group">
                                {{ Form::label('date','Date', ['class'=>'control-label col-md-2']) }}
                                <div class="col-md-4">
                                    {{ Form::text('date','', ['class'=>'form-control date-picker']) }}
                                </div>
                            </div>                        
                            <div class="form-group">
                                {{ Form::label('location','Location (Optional)', ['class'=>'control-label col-md-2']) }}
                                <div class="col-md-10">
                                {{ Form::select('locations[]', ['CY1' => 'Container Yard 1', 'CY3' => 'Container Yard 3', 'WF' => 'Wharf', 'MG' => 'Main Gate', 'PB' => 'Polis Bantuan'], null, ['class' => 'form-control', 'placeholder' => 'You can choose multiple locations', 'multiple', 'id'=>'location', 'spinner']) }}
                                <span class="help-block">Leave it blank to display all location.</span>
                                </div>
                            </div>                                 
                        </div>
                        <div class="form-actions">
                            <div class="row"><div class="col-md-offset-2 col-md-9">
                                <button class="btn btn-primary" id="but_generate">Generate</button>
                            </div></div>
                        </div>
                    </div>  

                    {{ Form::close() }}

                </div>
            </div>
        </div>   
    </div>

@stop

@section('page_level_plugins')

<script type="text/javascript" src="{{ URL::asset('assets/app/bootstrap-datepicker-1.4.0-dist/js/bootstrap-datepicker.min.js') }}"></script>

@stop

@section('scripts')

$('.date-picker').datepicker({
    format: "yyyy-mm-dd",
    todayBtn: "linked",
    autoclose: true,
    todayHighlight: true
});

$('.date-picker').datepicker('update', new Date());

$(".date-picker").datepicker().on('show.bs.modal', function(event) {
    // prevent datepicker from firing bootstrap modal "show.bs.modal"
    event.stopPropagation(); 
});

$('#location').select2();


$('#but_generate').on('click', function(e){
    e.preventDefault();
    console.log($('#location').val() );  

    if( $('#date').val() != null ) {
        window.open("{{ route('reports.container.movement.rpt') }}?date=" + $('#date').val() + "&locations=" + JSON.stringify($('#location').val()), "_newtab");
    }
});



@stop
@extends('layouts/default')

@section('page_level_styles')
<!-- BEGIN PAGE LEVEL STYLES -->
<!-- END PAGE LEVEL STYLES -->
@stop
@section('content')

	<h3 class="page-title">
		Export Cargo List by Consignor <small>report</small>
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
                                {{ Form::label('consignor_id','Consignor', ['class'=>'control-label col-md-2']) }}
                                <div class="col-md-10">
                                {{ Form::text('consignor_id','', ['class'=>'form-control']) }}
                                <span class="help-block">Choose a consignor</span>
                                </div>
                            </div> 
                            <div class="form-group">
                                {{ Form::label('year','Year', ['class'=>'control-label col-md-2']) }}
                                <div class="col-md-4">
                                    {{ Form::text('year','', ['class'=>'form-control date-picker']) }}
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

@section('scripts')

select2Plugin('#consignor_id', "{{route('workorders.handler_list')}}", "", "Please select a consignor");

$('.date-picker').datepicker({
    format: "yyyy",
    todayBtn: "linked",
    autoclose: true,
    todayHighlight: true,
    minViewMode: 2
});

$('.date-picker').datepicker('update', new Date());

$(".date-picker").datepicker().on('show.bs.modal', function(event) {
    // prevent datepicker from firing bootstrap modal "show.bs.modal"
    event.stopPropagation(); 
});

$('#but_generate').on('click', function(e){
    e.preventDefault();

    console.log($('#consignor_id').val());
    console.log($('#year').val());

    if( $('#consignor_id').val() == '' ) {
        return false;
    }

    if( $('#year').val() == null ) {
        return false;
    }

    window.open("{{ route('reports.cargo.list.export.rpt') }}?consignor_id=" + $('#consignor_id').val() + "&year=" + $('#year').val(), "_newtab");

});

@stop
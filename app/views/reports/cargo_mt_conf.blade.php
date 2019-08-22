@extends('layouts/default', ['vuePage' => 'cargo-mt-conf'])

@section('page_level_styles')
@stop
@section('content')

	<h3 class="page-title">
		Total Cargo MT <small>report</small>
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

                    <form @submit.prevent="onSubmit" action="{{ route('reports.cargo.mt.rpt') }}">

                    <div class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group">
                                {{ Form::label('year','Year', ['class'=>'control-label col-md-2']) }}
                                <div class="col-md-4">
                                <select-year></select-year>
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
    <script src="{{ URL::asset('js/main.js') }}"></script>
@stop

@section('scripts')

@stop
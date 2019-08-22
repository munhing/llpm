@extends('layouts/default')

@section('page_level_styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>
@stop
@section('content')

	<h3 class="page-title">
		Unstuffing Activity <small>wizard</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('workorders') }}">Work Order</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Unstuffing Activity
			</li>					
		</ul>
	</div>	

	<div class="row">
		<div class="col-md-12">
			<div class="portlet box blue" id="form_wizard_1">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-gift"></i> Unstuffing Process - <span class="step-title">
						Step 1 of 4 </span>
					</div>
				</div>
				<div class="portlet-body form">

					<form action="{{ route('workorders.unstuffing') }}" class="form-horizontal" id="submit_form" method="POST">
						<div class="form-wizard">
							<div class="form-body">
								<ul class="nav nav-pills nav-justified steps">
									<li>
										<a href="#tab1" data-toggle="tab" class="step">
										<span class="number">
										1 </span>
										<span class="desc">
										<i class="fa fa-check"></i> Carrier/Handler Setup </span>
										</a>
									</li>
									<li>
										<a href="#tab2" data-toggle="tab" class="step active">
										<span class="number">
										2 </span>
										<span class="desc">
										<i class="fa fa-check"></i> Container Setup </span>
										</a>
									</li>
									<li>
										<a href="#tab3" data-toggle="tab" class="step">
										<span class="number">
										3 </span>
										<span class="desc">
										<i class="fa fa-check"></i> Confirm </span>
										</a>
									</li>
								</ul>
								<div id="bar" class="progress progress-striped" role="progressbar">
									<div class="progress-bar progress-bar-success">
									</div>
								</div>
								<div class="tab-content">
									<div class="tab-pane" id="tab1">
										<h3 class="block">Handler/Carrier Selection</h3>
										<div class="form-group">
											<label class="control-label col-md-3">Handler <span class="required">
											* </span>
											</label>
											<div class="col-md-4">
												<input id="handler_id" name="handler_id" type="hidden" data-placeholder="Choose a handler..." class="form-control" />
												<span class="help-block">
												Select a Handler </span>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3">Carrier <span class="required">
											* </span>
											</label>
											<div class="col-md-4">
												<input id="carrier_id" name="carrier_id" type="hidden" data-placeholder="Choose a handler..." class="form-control" />
												<span class="help-block">
												Select a Carrier </span>
											</div>
										</div>												
									</div>
									<div class="tab-pane" id="tab2">
										<h3 class="block">Containers</h3>
										<div class="form-group">
											<label class="control-label col-md-3">Containers <span class="required">
											* </span>
											</label>
											<div class="col-md-4">
												{{ Form::select('containers[]', $containers->lists('container_no', 'id'), null, ['class' => 'form-control select2me', 'placeholder' => 'Select Containers', 'multiple', 'id'=>'ctn', 'spinner']) }}
												<span class="help-block">
												</span>
											</div>
										</div>

									</div>
									<div class="tab-pane" id="tab3">
										<h3 class="block">Confirm Work Order</h3>
										<h4 class="form-section">Details</h4>
																		
										<div class="form-group">
											<label class="control-label col-md-3">Handler:</label>
											<div class="col-md-4">
												<p class="form-control-static" data-display="handler_id">
												</p>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3">Carrier:</label>
											<div class="col-md-4">
												<p class="form-control-static" data-display="carrier_id">
												</p>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3">Containers:</label>
											<div class="col-md-4">
												<p class="form-control-static" id="selected_containers">
												</p>
											</div>
										</div>
										
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<a href="javascript:;" class="btn default button-previous">
										<i class="m-icon-swapleft"></i> Back </a>
										<a href="javascript:;" class="btn blue button-next">
										Continue <i class="m-icon-swapright m-icon-white"></i>
										</a>
										<a href="javascript:;" class="btn green button-submit">
										Submit <i class="m-icon-swapright m-icon-white"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>



@stop

@section('page_level_plugins')
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/components-pickers.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"></script>

<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"></script>

<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
@stop

@section('page_level_scripts')
<script src="{{ URL::asset('assets/admin/pages/scripts/components-dropdowns.js') }}"></script>
<script src="{{ URL::asset('assets/admin/pages/scripts/form-wizard-unstuff.js') }}"></script>
@stop

@section('scripts')
//ComponentsPickers.init();
//ComponentsDropdowns.init();
FormWizard.init();

$(function() {

	$('#handler_id, #carrier_id').select2({
		minimumInputLength: 4,
		ajax: {
			url: '{{ route('workorders.handler_list') }}',
			quietMillis: 1000,
			type: 'GET',
			data: function (term, page) {
				return {
					q:term
				};
			},
			results: function (data, page) {
				console.log(data);
				return {
					results: data
				};
			}
		},
	});

    $('#ctn').change(function() {

    	var text1 = $('.select2-search-choice div');
    	var text2 = '';

    	$.each(text1, function(key, value) {

    		//text2 = value.children('div').text();
    		console.log(value.innerHTML);
    		text2 += value.innerHTML + "\xa0 \xa0";
    		
    	})

    	$('#selected_containers').text(text2);

    });
        
});

@stop


@extends('layouts/default')

@section('page_level_styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>
@stop
@section('content')

	<h3 class="page-title">
		{{ $importCargo->bl_no }} <small>information</small>
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
				<a href="{{ route('manifest.schedule.import', $schedule->id ) }}"> {{ $schedule->vessel->name}} v.{{ $schedule->voyage_no_arrival }} - Import</a>
				<i class="fa fa-angle-right"></i>
			</li>			
			<li>
				{{ $importCargo->bl_no }}
			</li>						
		</ul>
	</div>	

	<div class="row">
		{{ Form::open(['route'=>['manifest.schedule.import.cargoes.issue', $importCargo->import_vessel_schedule_id, $importCargo->id], 'id' => 'form_issue_dl']) }}	
		<div class="col-md-8 ">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-info"></i>Cargo
					</div>

					
					<div class="actions">
						@if($importCargo->dl_no == 0 && $importCargo->status == 2)
                            
                            <button class='btn btn-sm btn-info' data-confirm>
                                Issue DL
                            </button>
                            
						@elseif($importCargo->dl_no != 0)
							<a href="{{ URL::route('manifest.schedule.import.cargoes.generate', [$schedule->id, $importCargo->id]) }}" class="btn btn-default btn-sm" target="_blank">
								<i class="fa fa-edit"></i> View DL 
							</a>
						@endif

						<a href="{{ route('manifest.schedule.import.cargoes.edit', [$schedule->id, $importCargo->id]) }}" class="btn btn-default btn-sm">
							<i class="fa fa-edit"></i> Edit 
						</a>

					</div>
					

				</div>
				<div class="portlet-body">
					<div class="row static-info">
						<div class="col-md-3 name">
							Vessel:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->vessel_schedule_import }}
						</div>						
					</div>
					<div class="row static-info">
						<div class="col-md-3 name">
							ETA | ETD:
						</div>
						<div class="col-md-9 value">
							{{ $schedule->eta->format('d/m/Y') }} | {{ $schedule->etd->format('d/m/Y') }}
						</div>						
					</div>								
					<div class="row static-info">
						<div class="col-md-3 name">
							B/L #:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->bl_no }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							D/L #:
						</div>
						<div class="col-md-9 value">
							@if($importCargo->status == 1)
								<span class="font-red-thunderbird">Unable to issue DL until this cargo has confirmed received.</span>
							@else
								@if( $importCargo->dl_no == 0)
									<span class="font-blue">DL not issue yet.</span>
								@else
									{{ $importCargo->dl_no }}
								@endif								
							@endif
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Consignor:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->consignor->name }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Consignee:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->consignee->name }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							MT:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->mt }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							M3:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->m3 }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Description:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->description }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Markings:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->markings }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Custom Registration #:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->custom_reg_no }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Custom Form #:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->custom_form_no }}
						</div>						
					</div>

					<div class="row static-info">
						<div class="col-md-3 name">
							Port of Loading:
						</div>
						<div class="col-md-9 value">
							{{ $importCargo->country_code }} / {{ $importCargo->port_code }}
						</div>						
					</div>
				</div>
			</div>
		</div>
		{{ Form::close() }}

		{{ Form::open(['route'=>['manifest.schedule.import.cargoes.containers.create', $importCargo->import_vessel_schedule_id, $importCargo->id], 'id'=>'form_add_containers']) }}	

		<div id="myModal_autocomplete" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Add Containers</h4>
					</div>
					<div class="modal-body form">
						
						
						<div class="form-horizontal form-row-seperated">
							<div class="form-group">
								<div class="col-sm-12">
									<div class="input-group">
										<span class="input-group-addon">
										<i class="fa fa-user"></i>
										</span>
										{{ Form::textarea('containers', null, ['class' => 'form-control placeholder-no-fix', 'autocomplete' => 'off', 'placeholder' => 'Containers', 'rows' => '3', 'id' => 'containers']) }}
									</div>
									<p class="help-block">
										E.g: PCIU1112223-20, TCIU4443332-40
									</p>
								</div>
							</div>
						</div>	
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-primary" id="but_add_container" data-confirm>
					</div>
				</div>
			</div>
		</div>
		{{ Form::close() }}

		<div class="col-md-4">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box red">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-info"></i>Containers
					</div>
					@if($importCargo->status == 1)
					<div class="actions">
						<a href="#myModal_autocomplete" role="button" class="btn btn-default btn-sm" data-toggle="modal">
							<i class="fa fa-plus"></i> Add
						</a>						
					</div>
					@endif			
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
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; ?>
								@foreach($importCargo->m_containers as $container)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ $container->container_no }}</td>
										<td>{{ $container->size }}</td>
										<td>{{ $container->m_content }}</td>
										<td>
											@if($container->status == 1 && $container->current_movement == 0)
											{{ Form::open(['route'=>['manifest.schedule.import.cargoes.detach', $importCargo->import_vessel_schedule_id, $importCargo->id], 'id' => 'form_unlink_container']) }}
											{{ Form::hidden('container_id', $container->id) }}
					                            <button class='btn btn-sm btn-danger' data-confirm>
					                                <i class="fa fa-unlink"></i>
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
		</div>
	</div>

	<div class="row">
		
		<div class="col-md-8 ">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-info"></i>Cargo Items
					</div>
					<div class="actions">
						<a class="btn btn-default btn-sm" data-target="#myModal_cargoitem" data-toggle="modal" data-title="Add Cargo Item">
							<i class="fa fa-plus"></i> Add 
						</a>						
					</div>					
				</div>
				<div class="portlet-body">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Code</th>
									<th>Description</th>
									<th>Qty</th>
									<th>Unit</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1; ?>
								@foreach($importCargoItems as $item)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ $item->custom_tariff_code }}</td>
										<td>{{ $item->description }}</td>
										<td align="right">{{ number_format($item->quantity, 2) }}</td>
										<td>
											@if(isset($item->custom_tariff->uoq))
												{{ $item->custom_tariff->uoq }}
											@endif
										</td>
										<td>
                                            <button class='btn btn-sm' type='button' data-toggle="modal" data-target="#myModal_cargoitem" data-title="Update Cargo Item" data-action="update" data-cargo-item-id="{{$item->id}}" data-tariff="{{$item->custom_tariff_code}}" data-uoq="{{$item->custom_tariff->uoq}}" data-description="{{$item->description}}" data-quantity="{{$item->quantity}}">
                                                <i class="fa fa-edit"></i>
                                            </button>
										</td>

									</tr>
								<?php $i++; ?>
								@endforeach
							</tbody>
						</table>



					</div>
				</div>
			</div>
		</div>
	</div>

    <div class="row">
    {{ Form::open(['route'=>['manifest.schedule.import.cargoes.item.create', $importCargo->import_vessel_schedule_id, $importCargo->id], 'id'=>'form_cargo_item']) }}	

    <div class="modal fade" id="myModal_cargoitem" role="dialog" aria-labelledby="myModalCargoItemLabel" aria-hidden="true" data-backdrop="static">
    	<div class="modal-dialog modal-lg">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    				<h4 class="modal-title" id="myModalCargoItemLabel">Add Cargo Item</h4>
                    {{ Form::hidden('form_action', '', ['id'=>'form_action']) }}
                    {{ Form::hidden('cargo_item_id', '', ['id'=>'cargo_item_id']) }}
    			</div>
    			<div class="modal-body">
                    <div class="container-fluid">
        				<div class="form-horizontal">
                            <div class="row">
            					<div class="form-group">
            						<label class="control-label col-md-2">Tariff Code</label>
            						<div class="col-md-6">
            							{{ Form::text('custom_tariff_code','', ['id'=>'custom_tariff_code', 'class'=>'form-control']) }}
                                        <span id="err-tariff" class="badge badge-danger"></span>
                                        <span id="suc-tariff" class="badge badge-success"></span>
                                        <span id="inf-tariff" class="badge badge-info"></span>
            						</div>

                                    <label class="control-label col-md-2">Unit of Quantity</label>
                                    <div class="col-md-2">
                                        {{ Form::text('uoq','', ['id'=>'uoq','class'=>'form-control']) }}
                                    </div>                                   
            					</div>	
                            </div>
                            <div class="row">
            					<div class="form-group">
            						<label class="control-label col-md-2">Description</label>
            						<div class="col-md-10">
            							{{ Form::textarea('description','', ['id'=>'description','class'=>'form-control', 'rows'=>'3']) }}
            						</div>
            					</div>
                            </div>
                            <div class="row">
            					<div class="form-group last">
            						<label class="control-label col-md-2">Quantity</label>
            						<div class="col-md-4">
            							{{ Form::text('quantity','', ['id'=>'quantity','class'=>'form-control']) }}
                                        <span id="err-quantity" class="badge badge-danger"></span>
                                        <span id="suc-quantity" class="badge badge-success"></span>
                                        <span id="inf-quantity" class="badge badge-info"></span>            							
            						</div>
            					</div>
                            </div>											
        				</div>	
                    </div>
    				
    			</div>
    			<div class="modal-footer">
    				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    				<input type="submit" class="btn btn-primary" id="but_cargo_item" data-confirm="Are you sure?">
    			</div>
    		</div>
    	</div>
    </div>

    {{ Form::close() }}
      
    </div>


@stop

@section('page_level_plugins')
@stop

@section('page_level_scripts')

@stop

@section('scripts')

$('#but_add_container1').on('click', function(event){
	event.preventDefault();

	console.log($.trim($('#containers').val()));

	if(! $.trim($('#containers').val()) == "") {
		$('#form_add_containers').submit();
	}
});

$('#custom_tariff_code').on('keydown', function(e){
    console.log(e);
    removeAllPrompts('tariff');

    if (!isNumber(e)) {

        //display error message
        promptError("Numbers Only", "tariff");
        return false;
    }

    if ($(this).val().length == 9) {
        //display error message
        if (!isAllowedKey(e)) {
            promptError("Cannot be more than 9 characters", "tariff");
            return false;
        }
    }    
});

$('#quantity').on('keydown', function(e){
    console.log(e);
    removeAllPrompts();

    if (!isNumber(e, true)) {

        //display error message
        promptError("Numbers Only", "quantity");
        return false;
    }   
});

$('#custom_tariff_code').on('blur', function(e){
    if($(this).val().length != 9) {
        promptError("Must be exactly 9 digits", false);
        return false;
    }

    $.ajax({
        url: '{{ route('tariff.find') }}',
        dataType: 'json',
        type: 'GET',
        data: { tariff_code : $(this).val() },
        success: function(data) {

            console.log(data);
            // console.log(data.uoq);

            if(data == null) {
                promptInfo("This is a new tariff code. Please specify the Unit of Quantity for this code.", "tariff", false);

                // enable the uoq field
                enableUoq();
                return false;
            }

            promptSuccess("Tariff code matched!", "tariff", false);
            $('#uoq').val(data.uoq);
            disableUoq();

        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
});

$('#myModal_cargoitem').on('hidden.bs.modal', function (e) {
    // clear form field
    clearForm();
});

$('#myModal_cargoitem').on('show.bs.modal', function (e) {

    $button = $(e.relatedTarget);
    $title = $button.data('title');
    $cargoItemId = $button.data('cargo-item-id');
    $tariff = $button.data('tariff');
    $uoq = $button.data('uoq');
    $description = $button.data('description');
    $quantity = $button.data('quantity');
    $action = $button.data('action');

    console.log($action);

    $(this).find('.modal-title').text($title);

    $('#cargo_item_id').val($cargoItemId);
    $('#custom_tariff_code').val($tariff);
    $('#uoq').val($uoq);
    $('#description').val($description);
    $('#quantity').val($quantity);
    $('#form_action').val($action);

    if($('#form_action').val() == 'update') {
        $('form').attr('action', "{{ route('manifest.schedule.import.cargoes.item.update',[$importCargo->import_vessel_schedule_id, $importCargo->id]) }}");
    } else {
        $('form').attr('action', "{{ route('manifest.schedule.import.cargoes.item.create',[$importCargo->import_vessel_schedule_id, $importCargo->id]) }}");
    }    
});

function clearForm()
{
    $('#custom_tariff_code').val('');
    $('#uoq').val('');
    $('#description').val('');
    $('#quantity').val('');
    removeAllPrompts('tariff');
}

function enableUoq()
{
    $('#uoq').focus();
}

function disableUoq()
{
    $('#description').focus();
}

function promptError(message, selector, fade)
{
    $("#suc-"+ selector).fadeOut(2000);
    $("#inf-"+ selector).fadeOut(2000);
    
    if(fade == false) {
        $("#err-"+ selector).html(message).show();
        return;
    }

    $("#err-"+ selector).html(message).show().fadeOut(2000);

}

function promptSuccess(message, selector, fade)
{
    $("#err-"+ selector).fadeOut(2000);
    $("#inf-"+ selector).fadeOut(2000);

    if(fade == false) {
        $("#suc-"+ selector).html(message).show();
        return;
    }
    
    $("#suc-"+ selector).html(message).show().fadeOut(2000);
}

function promptInfo(message, selector, fade)
{
    $("#err-"+ selector).fadeOut(2000);
    $("#suc-"+ selector).fadeOut(2000);

    if(fade == false) {
        $("#inf-"+ selector).html(message).show();
        return;
    }
    
    $("#inf-"+ selector).html(message).show().fadeOut(2000);
}

function removeAllPrompts(selector)
{
    $("#err-"+ selector).fadeOut(2000);
    $("#suc-"+ selector).fadeOut(2000);
    $("#inf-"+ selector).fadeOut(2000);
}

function isNumber(e, period)
{
	if(period == true) {
		if(isNumericKey(e) || isAllowedKey(e) || isPeriodKey(e)) {
			console.log('Have Period');
            return true;
		}

		return false;
	}

	if(isNumericKey(e) || isAllowedKey(e)) {
        console.log('No Period');
		return true;
	}

	return false;
}

function isNumericKey(e)
{
	var char = e.which;
	if ((char < 48 || char > 57) && (char < 96 || char > 105)){
		return false;
	}

	return true;	
}

function isAllowedKey(e)
{
	var char = e.which;
	if ( char != 8 && char != 9 && char != 16 && char != 37 && char != 39 && char != 46 ){
		return false;
	}

	return true;	
}

function isPeriodKey(e)
{
	var char = e.which;
	
	if ( char != 110 && char != 190 ){
		return false;
	}

    periodCount = count($('#quantity').val());

    if(periodCount != 0) {
        return false;
    }

	return true;	
}

function count(string) {

    str = string.match(/\./igm);
    period = (str) ? str.length : 0;

    return period;
}
@stop


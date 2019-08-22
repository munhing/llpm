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
	Fees <small>settings</small>
</h3>

<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="{{ URL::route('home') }}">Home</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			Settings - Fees
		</li>					
	</ul>
</div>	

<div class="row">
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green-sharp">
                    <i class="fa fa-dollar font-green-sharp"></i>
                    <span class="caption-subject bold uppercase"> Haulage Fee (HI/HE)</span>
                    <span class="caption-helper">setting</span>
                </div>
                <div class="actions">
                    <button class='btn btn-default btn-xs' type='button' data-toggle="modal" data-target="#myModal_feeTemplate1" data-title="Add Haulage Fee" data-fee-type="haulage">
                        <i class="fa fa-plus"></i> Add 
                    </button>        
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>20E</th>
                        <th>20L</th>
                        <th>40E</th>    
                        <th>40L</th>    
                        <th>Effective Date</th>   
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach($haulageFees as $haulageFee)
                        <?php $fee = json_decode($haulageFee->fee, true); ?>
                        <tr>
                            <td align="center">{{ $i }}</td> 
                            <td align="right">{{ number_format($fee['20E'], 2) }}</td>
                            <td align="right">{{ number_format($fee['20L'], 2) }}</td>
                            <td align="right">{{ number_format($fee['40E'], 2) }}</td>                             
                            <td align="right">{{ number_format($fee['40L'], 2) }}</td>
                            <td align="center">{{ $haulageFee->effective_date->format('d/m/Y') }}</td>
                            <td align="center">
                                <button class='btn btn-default btn-xs' type='button' data-toggle="modal" data-target="#myModal_feeTemplate1" data-title="Update Haulage Fee" data-action="update" data-fee-type="haulage" data-fee-id="{{$haulageFee->id}}" data-e20="{{$fee['20E']}}" data-l20="{{$fee['20L']}}" data-e40="{{$fee['40E']}}" data-l40="{{$fee['40L']}}" data-effective-date="{{$haulageFee->effective_date->format('Y-m-d')}}">
                                    <i class="fa fa-pencil"></i> Edit 
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
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green-sharp">
                    <i class="fa fa-dollar font-green-sharp"></i>
                    <span class="caption-subject bold uppercase"> Lifting Fee (RI/RO)</span>
                    <span class="caption-helper">setting</span>
                </div>
                <div class="actions">
                    <button class='btn btn-default btn-xs' type='button' data-toggle="modal" data-target="#myModal_feeTemplate1" data-title="Add Lifting Fee" data-fee-type="lifting">
                        <i class="fa fa-plus"></i> Add 
                    </button>        
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>20E</th>
                        <th>20L</th>
                        <th>40E</th>    
                        <th>40L</th>    
                        <th>Effective Date</th>   
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach($liftingFees as $liftingFee)
                        <?php $fee = json_decode($liftingFee->fee, true); ?>
                        <tr>
                            <td align="center">{{ $i }}</td> 
                            <td align="right">{{ number_format($fee['20E'], 2) }}</td>
                            <td align="right">{{ number_format($fee['20L'], 2) }}</td>
                            <td align="right">{{ number_format($fee['40E'], 2) }}</td>                             
                            <td align="right">{{ number_format($fee['40L'], 2) }}</td>
                            <td align="center">{{ $liftingFee->effective_date->format('d/m/Y') }}</td>
                            <td align="center">
                                <button class='btn btn-default btn-xs' type='button' data-toggle="modal" data-target="#myModal_feeTemplate1" data-title="Update lifting Fee" data-action="update" data-fee-type="lifting" data-fee-id="{{$liftingFee->id}}" data-e20="{{$fee['20E']}}" data-l20="{{$fee['20L']}}" data-e40="{{$fee['40E']}}" data-l40="{{$fee['40L']}}" data-effective-date="{{$liftingFee->effective_date->format('Y-m-d')}}">
                                    <i class="fa fa-pencil"></i> Edit 
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
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green-sharp">
                    <i class="fa fa-dollar font-green-sharp"></i>
                    <span class="caption-subject bold uppercase"> Activity Fee (ST/US)</span>
                    <span class="caption-helper">setting</span>
                </div>
                <div class="actions">
                    <button class='btn btn-default btn-sm' type='button' data-toggle="modal" data-target="#myModal_feeTemplate2" data-title="Add Activity Fee" data-fee-type="activity">
                        <i class="fa fa-plus"></i> Add 
                    </button>        
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>20</th>
                        <th>40</th>    
                        <th>Effective Date</th>   
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach($activityFees as $activityFee)
                        <?php $fee = json_decode($activityFee->fee, true); ?>
                        <tr>
                            <td align="center">{{ $i }}</td> 
                            <td align="right">{{ number_format($fee['20'], 2) }}</td>
                            <td align="right">{{ number_format($fee['40'], 2) }}</td>
                            <td align="center">{{ $activityFee->effective_date->format('d/m/Y') }}</td>
                            <td align="center">
                                <button class='btn btn-default btn-xs' type='button' data-toggle="modal" data-target="#myModal_feeTemplate2" data-title="Update Activity Fee" data-action="update" data-fee-type="activity" data-fee-id="{{$activityFee->id}}" data-s20="{{$fee['20']}}" data-s40="{{$fee['40']}}" data-effective-date="{{$activityFee->effective_date->format('Y-m-d')}}">
                                    <i class="fa fa-pencil"></i> Edit 
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
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green-sharp">
                    <i class="fa fa-dollar font-green-sharp"></i>
                    <span class="caption-subject bold uppercase"> Transfer Fee (TF)</span>
                    <span class="caption-helper">setting</span>
                </div>
                <div class="actions">
                    <button class='btn btn-default btn-sm' type='button' data-toggle="modal" data-target="#myModal_feeTemplate2" data-title="Add Transfer Fee" data-fee-type="transfer">
                        <i class="fa fa-plus"></i> Add 
                    </button>        
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>20</th>
                        <th>40</th>    
                        <th>Effective Date</th>   
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach($transferFees as $transferFee)
                        <?php $fee = json_decode($transferFee->fee, true); ?>
                        <tr>
                            <td align="center">{{ $i }}</td> 
                            <td align="right">{{ number_format($fee['20'], 2) }}</td>
                            <td align="right">{{ number_format($fee['40'], 2) }}</td>
                            <td align="center">{{ $transferFee->effective_date->format('d/m/Y') }}</td>
                            <td align="center">
                                <button class='btn btn-default btn-xs' type='button' data-toggle="modal" data-target="#myModal_feeTemplate2" data-title="Update Transfer Fee" data-action="update" data-fee-type="transfer" data-fee-id="{{$transferFee->id}}" data-s20="{{$fee['20']}}" data-s40="{{$fee['40']}}" data-effective-date="{{$transferFee->effective_date->format('Y-m-d')}}">
                                    <i class="fa fa-pencil"></i> Edit 
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
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green-sharp">
                    <i class="fa fa-dollar font-green-sharp"></i>
                    <span class="caption-subject bold uppercase"> Empty Storage Fee</span>
                    <span class="caption-helper">setting</span>
                </div>
                <div class="actions">
                    <button class='btn btn-default btn-sm' type='button' data-toggle="modal" data-target="#myModal_feeTemplate2" data-title="Add Storage Fee" data-fee-type="storage">
                        <i class="fa fa-plus"></i> Add 
                    </button>         
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>20</th>
                        <th>40</th>    
                        <th>Effective Date</th>   
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach($storageFees as $storageFee)
                        <?php $fee = json_decode($storageFee->fee, true); ?>
                        <tr>
                            <td align="center">{{ $i }}</td> 
                            <td align="right">{{ number_format($fee['20'], 2) }}</td>
                            <td align="right">{{ number_format($fee['40'], 2) }}</td>                             
                            <td align="center">{{ $storageFee->effective_date->format('d/m/Y') }}</td>
                            <td align="center">
                                <button class='btn btn-default btn-xs' type='button' data-toggle="modal" data-target="#myModal_feeTemplate2" data-title="Update Storage Fee" data-action="update" data-fee-type="storage" data-fee-id="{{$storageFee->id}}" data-s20="{{$fee['20']}}" data-s40="{{$fee['40']}}" data-effective-date="{{$storageFee->effective_date->format('Y-m-d')}}">
                                    <i class="fa fa-pencil"></i> Edit 
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
    {{ Form::open(['id'=>'form_fee_template1']) }}   

    <div class="modal fade" id="myModal_feeTemplate1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="myModalLabel">Add Handling Fee</h4>
                    {{ Form::hidden('form_action', '', ['id'=>'form_action']) }}
                    {{ Form::hidden('fee_id', '', ['id'=>'fee_id']) }}
                    {{ Form::hidden('fee_type', '', ['id'=>'fee_type']) }}
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-horizontal">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2">20" Empty</label>
                                    <div class="col-md-4">
                                        {{ Form::text('e20','', ['id'=>'e20', 'class'=>'form-control']) }}
                                        <span id="err-e20" class="badge badge-danger"></span>
                                        <span id="suc-e20" class="badge badge-success"></span>
                                        <span id="inf-e20" class="badge badge-info"></span>
                                    </div>

                                    <label class="control-label col-md-2">20" Laden</label>
                                    <div class="col-md-4">
                                        {{ Form::text('l20','', ['id'=>'l20', 'class'=>'form-control']) }}
                                        <span id="err-l20" class="badge badge-danger"></span>
                                        <span id="suc-l20" class="badge badge-success"></span>
                                        <span id="inf-l20" class="badge badge-info"></span>
                                    </div>                                   
                                </div>  
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2">40" Empty</label>
                                    <div class="col-md-4">
                                        {{ Form::text('e40','', ['id'=>'e40', 'class'=>'form-control']) }}
                                        <span id="err-e40" class="badge badge-danger"></span>
                                        <span id="suc-e40" class="badge badge-success"></span>
                                        <span id="inf-e40" class="badge badge-info"></span>
                                    </div>

                                    <label class="control-label col-md-2">40" Laden</label>
                                    <div class="col-md-4">
                                        {{ Form::text('l40','', ['id'=>'l40', 'class'=>'form-control']) }}
                                        <span id="err-l40" class="badge badge-danger"></span>
                                        <span id="suc-l40" class="badge badge-success"></span>
                                        <span id="inf-l40" class="badge badge-info"></span>
                                    </div>                                   
                                </div>  
                            </div> 
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-5">Effective Date</label>
                                    <div class="col-md-4">
                                        {{ Form::text('effective_date1','', ['id'=>'effective_date1', 'class'=>'form-control date-picker']) }}
                                    </div>
                                </div>
                            </div>                                                                     
                        </div>  
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" id="but_storage_fee" data-confirm="Are you sure?">
                </div>
            </div>
        </div>
    </div>

    {{ Form::close() }}
      
    </div>

    <div class="row">
    {{ Form::open(['id'=>'form_fee_template2']) }}   

    <div class="modal fade" id="myModal_feeTemplate2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="myModalLabel">Add Handling Fee</h4>
                    {{ Form::hidden('form_action') }}
                    {{ Form::hidden('fee_id', '', ['id'=>'fee_id']) }}
                    {{ Form::hidden('fee_type') }}
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-horizontal">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2">20"</label>
                                    <div class="col-md-4">
                                        {{ Form::text('s20','', ['id'=>'s20', 'class'=>'form-control']) }}
                                        <span id="err-s20" class="badge badge-danger"></span>
                                        <span id="suc-s20" class="badge badge-success"></span>
                                        <span id="inf-s20" class="badge badge-info"></span>
                                    </div>

                                    <label class="control-label col-md-2">40"</label>
                                    <div class="col-md-4">
                                        {{ Form::text('s40','', ['id'=>'s40', 'class'=>'form-control']) }}
                                        <span id="err-s40" class="badge badge-danger"></span>
                                        <span id="suc-s40" class="badge badge-success"></span>
                                        <span id="inf-s40" class="badge badge-info"></span>
                                    </div>                                   
                                </div>  
                            </div> 
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-5">Effective Date</label>
                                    <div class="col-md-4">
                                        {{ Form::text('effective_date2','', ['id'=>'effective_date2', 'class'=>'form-control date-picker']) }}
                                    </div>
                                </div>
                            </div>                                                                     
                        </div>  
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" id="but_storage_fee" data-confirm="Are you sure?">
                </div>
            </div>
        </div>
    </div>

    {{ Form::close() }}
      
    </div>    
@stop

@section('page_level_plugins')

<script type="text/javascript" src="{{ URL::asset('assets/app/bootstrap-datepicker-1.4.0-dist/js/bootstrap-datepicker.min.js') }}"></script>

@stop

@section('scripts')

$('#myModal_feeTemplate1').on('show.bs.modal', function (e) {

    $button = $(e.relatedTarget);
    $title = $button.data('title');

    $e20 = $button.data('e20');
    $l20 = $button.data('l20');
    $e40 = $button.data('e40');
    $l40 = $button.data('l40');
    $effectiveDate = $button.data('effective-date');
    console.log('Eff_Date: ' + $effectiveDate);
    $feeId = $button.data('fee-id');
    $feeType = $button.data('fee-type');
    $action = $button.data('action');

    // console.log($action);
    console.log('show.bs.modal');

    $(this).find('.modal-title').text($title);

    $('#e20').val($e20);
    $('#l20').val($l20);
    $('#e40').val($e40);
    $('#l40').val($l40);
    // $('#fee_id').val($feeId);
    $("input[name='fee_id']").val($feeId);
    $("input[name='fee_type']").val($feeType);
    $("input[name='form_action']").val($action);    

    if($effectiveDate) {
        var strDate = $effectiveDate.split(/[- :]/);
        console.log(strDate);
        var newDate = new Date(strDate[0], strDate[1]-1, strDate[2]);
        $('#effective_date1').datepicker('update',newDate);
    } else {
        $('#effective_date1').datepicker('update', new Date());
    }

});

$('#myModal_feeTemplate2').on('show.bs.modal', function (e) {

    $button = $(e.relatedTarget);
    $title = $button.data('title');

    $s20 = $button.data('s20');
    $s40 = $button.data('s40');
    $effectiveDate = $button.data('effective-date');
    console.log('Eff_Date: ' + $effectiveDate);
    $feeId = $button.data('fee-id');
    $feeType = $button.data('fee-type');
    $action = $button.data('action');

    // console.log($action);
    console.log('show.bs.modal');

    $(this).find('.modal-title').text($title);

    $('#s20').val($s20);
    $('#s40').val($s40);
    // $('#fee_id').val($feeId);
    $("input[name='fee_id']").val($feeId);
    $("input[name='fee_type']").val($feeType);
    $("input[name='form_action']").val($action);

    if($effectiveDate) {
        var strDate = $effectiveDate.split(/[- :]/);
        var newDate = new Date(strDate[0], strDate[1]-1, strDate[2]);
        $('#effective_date2').datepicker('update',newDate);
    } else {
        $('#effective_date2').datepicker('update', new Date());
    }

});

$('.date-picker').datepicker({
    format: "dd/mm/yyyy",
    todayBtn: "linked",
    autoclose: true,
    todayHighlight: true
});

$(".date-picker").datepicker().on('show.bs.modal', function(event) {
    // prevent datepicker from firing bootstrap modal "show.bs.modal"
    event.stopPropagation(); 
});

$('#e20, #l20, #e40, #l40, #s20, #s40').on('keydown', function(e){
    // console.log(e.target.id);
    console.log('Only price');
    //removeAllPrompts();

    if (!isNumber(e, true)) {

        //display error message
        promptError("Numbers Only", e.target.id);
        return false;
    }   
});

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

    periodCount = count($('#'+e.target.id).val());

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